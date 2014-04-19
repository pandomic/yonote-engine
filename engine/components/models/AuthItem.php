<?php
class AuthItem extends CActiveRecord
{
    
    public $name;
    public $description;
    public $permissions;
    
    public function rules()
    {
        return array(
            array(
                'name','unique','on' => 'add',
                'message' => Yii::t('users','model.authitem.error.name.unique')
            ),
            array (
                'name','match','allowEmpty' => false,'pattern' => '/[a-z0-9_]+/iu','on' => 'add',
                'message' => Yii::t('users','model.authitem.error.name.match')
            ),
            array (
                'name','length','on' => 'add',
                'min' => 2,
                'max' => 50,
                'tooShort' => Yii::t('users','model.authitem.error.name.short'),
                'tooLong' => Yii::t('users','model.authitem.error.name.long')
            ),
            array(
                'description','match','allowEmpty' => false,'pattern' => '/\w+/iu',
                'message' => Yii::t('users','model.authitem.error.description.match')
            ),
            array(
                'description','length',
                'min' => 2,
                'max' => 50,
                'tooShort' => Yii::t('users','model.authitem.error.description.short'),
                'tooLong' => Yii::t('users','model.authitem.error.description.long')
            ),
            array('permissions','permissionsRule')
        );
    }
    
    public function attributeLabels(){
        return array(
            'name' => Yii::t('users','model.authitem.name'),
            'description' => Yii::t('users','model.authitem.description'),
            'permissions' => Yii::t('users','model.authitem.permissions')
        );
    }
    
    public function permissionsRule($attribute,$params)
    {
        $foundCount = count(self::model()->findAllByPk($this->permissions));
        if ($foundCount <= 0)
            $this->addError($attribute,Yii::t('users','model.authitem.error.permissions'));
        if (is_array($this->permissions))
            if (count($this->permissions) != $foundCount)
                $this->addError($attribute,Yii::t('users','model.authitem.error.permissions'));
    }
    
    public function afterSave(){
        AuthItemChild::model()->deleteAll(
            'parent=:itemid',
            array(':itemid' => $this->name)
        );
        foreach ($this->permissions as $item)
            Yii::app()->authManager->addItemChild($this->name,$item);
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
    
    public function relations(){
        return array(
            'childrelations' => array(self::HAS_MANY,'AuthItemChild','parent'),
            'parentrelations' => array(self::HAS_MANY,'AuthItemChild','child'),
            'children' => array(self::HAS_MANY,'AuthItem',array('child' => 'name'),'through' => 'childrelations'),
            'parents' => array(self::HAS_MANY,'AuthItem',array('parent' => 'name'),'through' => 'parentrelations')
        );
    }
}
?>