<?php
/**
 * AuthItem class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

/**
 * AuthItem model class is used to manage single authorization items. It also
 * has relations to AuthItemChild class, that allows to fetch parent and child
 * items.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class AuthItem extends CActiveRecord
{
    /**
     * @var string auth item name.
     */
    public $name;
    /**
     *
     * @var type string auth item description.
     */
    public $description;
    /**
     * @var array parent elements.
     */
    public $parents;
    /**
     * @var type item type.
     */
    public $type;

    private $_uniqueItems = null;
    private $_allItemsData = null;
    private $_friendlyTree = null;
    
    /**
     * Validation rules.
     * @return array validation rules.
     */
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
    
    /**
     * Attribute labels.
     * @return array attribute labels.
     */
    public function attributeLabels(){
        return array(
            'name' => Yii::t('users','model.authitem.name'),
            'description' => Yii::t('users','model.authitem.description'),
            'parents' => Yii::t('users','model.authitem.parent')
        );
    }
    
    /**
     * Action, that will be executed before validating.
     * Uniquely sorts parents.
     * @return boolean parent beforeValidate() status.
     */
    public function beforeValidate(){
        if ($this->parents !== null)
            $this->parents = array_unique($this->parents);
        return parent::beforeValidate();
    }
    
    /**
     * Validation rule.
     * Validate parent items existence.
     * @param string $attribute attribute name.
     * @param array $params additional params.
     */
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
    
    /**
     * Validation rule.
     * Detect loop in items relations.
     * @param string $attribute attribute name.
     * @param array $params additional params.
     */
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
    
    /**
     * Validation rule.
     * Prevent self-linking.
     * @param string $attribute attribute name.
     * @param array $params additional params.
     */
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
    
    /**
     * Validation rule.
     * Check, if selected elements are roles.
     * @param string $attribute attribute name.
     * @param array $params additional params.
     */
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
    
    /**
     * Action, that will be called after model saving.
     * @return boolean parent afterSave() status.
     */
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
    
    /**
     * Return static model of AuthItem.
     * @param string $className current class name.
     * @return AuthItem object.
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    /**
     * Model database table name.
     * @return string table name.
     */
    public function tableName()
    {
        return '{{auth_item}}';
    }
    
    /**
     * Model relations.
     * Relations:
     *     childrelations - direct child relations of current item;
     *     parentrelations - direct parent relations of current item;
     *     children - direct child items of current item;
     *     parents - direct parent items of current item.
     * @return array relations.
     */
    public function relations()
    {
        return array(
            'childrelations' => array(self::HAS_MANY,'AuthItemChild','parent'),
            'parentrelations' => array(self::HAS_MANY,'AuthItemChild','child'),
            'children' => array(self::HAS_MANY,'AuthItem',array('child' => 'name'),'through' => 'childrelations'),
            'parents' => array(self::HAS_MANY,'AuthItem',array('parent' => 'name'),'through' => 'parentrelations')
        );
    }
    
    /**
     * Get all auth items.
     * @return array auth items.
     */
    public function getAllItems()
    {
        if ($this->_allItemsData === null)
            $this->_allItemsData = self::model()->findAll();
        return $this->_allItemsData;
    }
    
    /**
     * Get auth items uniquely.
     * @return array auth items.
     */
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
    
    /**
     * Build plane auth items tree.
     * @return array plane auth items tree.
     */
    public function friendlyTree()
    {
        if ($this->_friendlyTree !== null)
            return $this->_friendlyTree;
        $this->_friendlyTree = array();
        $unusedKeys = $this->getAuthItemsUnique();
        $this->_friendlyTree = $this->_iterate(AuthItemChild::model()->tree(),0);
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
    
    /**
     * Return auth item type by key.
     * @param integer $type item type.
     * @return string item type name.
     */
    public function type($type)
    {
        switch ($type)
        {
            case 2: return Yii::t('users','label.role');
            case 1: return Yii::t('users','label.task');
            default: return Yii::t('users','label.operation');
        }
    }
    
    /**
     * friendlyTree() iteration.
     * @param array $array array to iterate.
     * @param integer $deep current depth.
     * @return array plane tree.
     */
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
    
    /**
     * Detect loop in items relations.
     * @param string $itemName parent item name.
     * @param string $childName child item name.
     * @return boolean loop detected.
     */
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