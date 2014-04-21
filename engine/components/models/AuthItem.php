<?php
class AuthItem extends CActiveRecord
{
    
    public $name;
    public $description;
    public $parents;
    public $type;

    private $_uniqueItems = null;
    private $_allItemsData = null;
    private $_friendlyTree = null;
    
    public function rules()
    {
        return array(
            array('type','in','on' => 'add','range' => array(2),'allowEmpty' => false),
            array(
                'name','unique','on' => 'add',
                'message' => Yii::t('users','model.authitem.error.name.unique')
            ),
            array (
                'name','match','allowEmpty' => false,'pattern' => '/[a-z0-9_]+/iu',
                'message' => Yii::t('users','model.authitem.error.name.match')
            ),
            array (
                'name','length',
                'min' => Yii::app()->settings->get('user','role.name.length.min'),
                'max' => Yii::app()->settings->get('user','role.name.length.max'),
                'tooShort' => Yii::t('users','model.authitem.error.name.short'),
                'tooLong' => Yii::t('users','model.authitem.error.name.long')
            ),
            array(
                'description','match','allowEmpty' => false,'pattern' => '/\w+/iu',
                'message' => Yii::t('users','model.authitem.error.description.match')
            ),
            array(
                'description','length',
                'min' => Yii::app()->settings->get('user','role.description.length.min'),
                'max' => Yii::app()->settings->get('user','role.description.length.max'),
                'tooShort' => Yii::t('users','model.authitem.error.description.short'),
                'tooLong' => Yii::t('users','model.authitem.error.description.long')
            ),
            array('parents','parentsRule'),
            array('parents','detectLoopRule','on' => 'edit'),
            array('parents','detectSelfRule','on' => 'edit'),
            array('parents','onlyRoleRule','on' => 'edit,add')
        );
    }
    
    public function attributeLabels(){
        return array(
            'name' => Yii::t('users','model.authitem.name'),
            'description' => Yii::t('users','model.authitem.description'),
            'parents' => Yii::t('users','model.authitem.parent')
        );
    }

    public function beforeValidate(){
        if ($this->parents !== null)
            $this->parents = array_unique($this->parents);
        return parent::beforeValidate();
    }

    public function parentsRule($attribute,$params)
    {
        if ($this->parents !== null)
        {
            $foundCount = count(self::model()->findAllByPk($this->parents));
            if ($foundCount <= 0 || !is_array($this->parents))
                $this->addError($attribute,Yii::t('users','model.authitem.error.parent.undefined'));
            if (count($this->parents) != $foundCount)
                $this->addError($attribute,Yii::t('users','model.authitem.error.parent.undefined'));
        }
    }
    
    public function detectLoopRule($attribute,$params)
    {
        if ($this->parents !== null)
            foreach ($this->parents as $parent)
                if ($this->_detectLoop($parent,$this->name))
                {
                    $this->addError($attribute,Yii::t('users','model.authitem.error.parent.loop'));
                    break;
                }
    }

    public function detectSelfRule($attribute,$params)
    {
        if ($this->parents !== null)
            foreach ($this->parents as $parent)
                if ($parent == $this->name)
                {
                    $this->addError($attribute,Yii::t('users','model.authitem.error.parent.self'));
                    break;
                }
    }

    public function onlyRoleRule($attribute,$params)
    {
        if ($this->parents !== null)
        {
            $allItems = $this->getAuthItemsUnique();
            foreach ($this->parents as $parent)
                if ($allItems[$parent]->type != 2)
                    $this->addError($attribute,Yii::t('users','model.authitem.error.parent.role'));
        }
        
    }
    
    public function afterSave(){
        AuthItemChild::model()->deleteAll(
            'child=:itemid',
            array(':itemid' => $this->name)
        );
        if ($this->parents !== null)
            foreach ($this->parents as $parent)
                Yii::app()->authManager->addItemChild($parent,$this->name);
        return parent::afterSave();
    }
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
 
    public function tableName()
    {
        return '{{auth_item}}';
    }
    
    public function relations()
    {
        return array(
            'childrelations' => array(self::HAS_MANY,'AuthItemChild','parent'),
            'parentrelations' => array(self::HAS_MANY,'AuthItemChild','child'),
            'children' => array(self::HAS_MANY,'AuthItem',array('child' => 'name'),'through' => 'childrelations'),
            'parents' => array(self::HAS_MANY,'AuthItem',array('parent' => 'name'),'through' => 'parentrelations')
        );
    }
    
    public function getAllItems()
    {
        if ($this->_allItemsData === null)
            $this->_allItemsData = self::model()->findAll();
        return $this->_allItemsData;
    }
    
    public function getAuthItemsUnique()
    {
        if ($this->_uniqueItems === null)
        {
            $allItems = $this->getAllItems();
            foreach ($allItems as $r)
                $this->_uniqueItems[$r->name] = $r;
        }
        return $this->_uniqueItems;
        
    }

    public function friendlyTree($type = null)
    {
        if ($this->_friendlyTree !== null)
            return $this->_friendlyTree;
        $this->_friendlyTree = array();
        $unusedKeys = $this->getAuthItemsUnique();
        $this->_friendlyTree = $this->_iterate(AuthItemChild::model()->tree(),0,$type);
        foreach ($this->_friendlyTree as $val)
        {
            list($k,$v) = each($val);
            foreach ($unusedKeys as $uKey => $uVal)
                if ($k == $uKey) unset($unusedKeys[$uKey]);
        }
        $additionalKeys = array();
        foreach ($unusedKeys as $k => $v)
            $additionalKeys[] = array($k => "|-+- {$v->description} ({$this->type($v->type)})");
        $this->_friendlyTree = array_merge($additionalKeys,$this->_friendlyTree);    
        return $this->_friendlyTree;
    }
    
    public function type($type)
    {
        switch ($type)
        {
            case 2: return Yii::t('users','label.role');
            case 1: return Yii::t('users','label.task');
            default: return Yii::t('users','label.operation');
        }
    }

    private function _iterate($array,$deep = 0)
    {
        $return = array();
        $indent = str_repeat('&nbsp;',$deep*3);
        if (is_array($array))
            foreach ($array as $k => $v)
            {
                if (is_array($v))
                {
                    $return[] = array($k => "{$indent}|-+- {$this->_uniqueItems[$k]->description} ({$this->type($this->_uniqueItems[$k]->type)})");
                    $return = array_merge($return,$this->_iterate($v,$deep+1));
                }
                else
                {
                    $return[] = array($v => "{$indent}|- {$this->_uniqueItems[$v]->description} ({$this->type($this->_uniqueItems[$v]->type)})");
                }
                    
            }
        else
            $return[] = $array;
        return $return;
    }
    
    private function _detectLoop($itemName,$childName)
    {
        if($childName===$itemName)
            return true;
        foreach(Yii::app()->authManager->getItemChildren($childName) as $child)
        {
            if($this->_detectLoop($itemName,$child->getName()))
                return true;
        }
        return false;
    }
}
?>