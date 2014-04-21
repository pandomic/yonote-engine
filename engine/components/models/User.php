<?php
class User extends CActiveRecord
{
    
    public $name;
    public $email;
    public $password;
    public $activated;
    public $verified;
    public $subscribed;
    public $permissions;
    
    public function rules()
    {
        return array(
            array(
                'name,email','required',
                'message' => Yii::t('users','model.user.error.required')
            ),
            array(
                'email','email',
                'message' => Yii::t('users','model.user.error.email')
            ),
            array(
                'name','unique','attributeName' => 'name',
                'message' => Yii::t('users','model.user.error.name.unique')
            ),
            array(
                'password','required','on' => 'add',
                'message' => Yii::t('users','model.user.error.required')
            ),
            array(
                'activated,verified,subscribed','boolean','allowEmpty' => false,
                'message' => Yii::t('users','model.user.error.flags')
            ),
            array('permissions','permissionsRule'),
            array(
                'name','match','pattern' => '/[a-z0-9_]/i',
                'message' => Yii::t('users','model.user.error.name.match')
            ),
            array(
                'name','length',
                'min' => Yii::app()->settings->get('user','name.length.min'),
                'max' => Yii::app()->settings->get('user','name.length.max'),
                'tooShort' => Yii::t('users','model.user.error.name.short'),
                'tooLong' => Yii::t('users','model.user.error.name.long')
            ),
            array(
                'password','length',
                'min' => Yii::app()->settings->get('user','password.length.min'),
                'max' => Yii::app()->settings->get('user','password.length.max'),
                'tooShort' => Yii::t('users','model.user.error.password.short'),
                'tooLong' => Yii::t('users','model.user.error.password.long')
            )
        );
    }
    
    public function attributeLabels(){
        return array(
            'name' => Yii::t('users','model.user.name'),
            'email' => Yii::t('users','model.user.email'),
            'password' => Yii::t('users','model.user.password'),
            'activated' => Yii::t('users','model.user.activated'),
            'verified' => Yii::t('users','model.user.verified'),
            'name' => Yii::t('users','model.user.name'),
            'permissions' => Yii::t('users','model.user.permissions')
        );
    }

    public function beforeSave()
    {
        
        if ($this->password != null)
            $this->password = CPasswordHelper::hashPassword($this->password);
        else if ($this->password == null && $this->getScenario() == 'edit')
            $this->password = self::model()->find(
                    'name=:name',array(':name'=>$this->name)
            )->password;
        return parent::beforeSave();
    }

    public function afterSave(){
        if ($this->getScenario() == 'add')
        {
            $profile = new Profile();
            $profile->userid = $this->name;
            $profile->save();
        }
        AuthAssignment::model()->deleteAll(
            'userid=:userid',
            array(':userid' => $this->name)
        );
        foreach ($this->permissions as $item)
            Yii::app()->authManager->assign($item,$this->name);
        return parent::afterSave();
    }
    
    public function beforeValidate()
    {
        if ($this->permissions != null)
            $this->permissions = array_unique($this->permissions);
        return parent::beforeValidate();
    }

    public function permissionsRule($attribute,$params)
    {
        $foundCount = count(AuthItem::model()->findAllByPk($this->permissions));
        if ($foundCount <= 0 || !is_array($this->permissions))
            $this->addError($attribute,Yii::t('users','model.user.error.permissions'));
        if (count($this->permissions) != $foundCount)
            $this->addError($attribute,Yii::t('users','model.user.error.permissions'));
    }
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function tableName(){
        return '{{user}}';
    }
    
    public function relations(){
        return array(
            'assignments' => array(self::HAS_MANY,'AuthAssignment','userid'),
            'items' => array(self::HAS_MANY,'AuthItem',array('itemname' => 'name'),'through' => 'assignments'),
            'profile' => array(self::HAS_ONE,'Profile','userid')
        );
    }
}
?>