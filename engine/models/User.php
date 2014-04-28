<?php
/**
 * User class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

/**
 * User model class.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class User extends CActiveRecord
{
    /**
     * @var string user name.
     */
    public $name;
    /**
     * @var string user email.
     */
    public $email;
    /**
     * @var string user password.
     */
    public $password;
    /**
     * @var boolean user is activated.
     */
    public $activated;
    /**
     * @var boolean users email is verified.
     */
    public $verified;
    /**
     * @var boolean user is subscribed for newsletters.
     */
    public $subscribed;
    /**
     * @var string user permissions.
     */
    public $permissions;
    
    /**
     * Validation rules.
     * @return array validation rules.
     */
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
    
    /**
     * Attribute labels.
     * @return array attribute labels.
     */
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
    
    /**
     * Action, that will be called before model saving.
     * @return boolean parent beforeSave() status.
     */
    public function beforeSave()
    {
        $this->updatetime = time();
        if ($this->password != null)
            $this->password = CPasswordHelper::hashPassword($this->password);
        else if ($this->password == null && $this->getScenario() == 'edit')
            $this->password = self::model()->find(
                    'name=:name',array(':name'=>$this->name)
            )->password;
        return parent::beforeSave();
    }
    
    /**
     * Action, that will be called after model saving.
     * @return boolean parent afterSave() status.
     */
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
    
    /**
     * Action, that will be called before model will be validated.
     * @return boolean parent beforeValidate() status.
     */
    public function beforeValidate()
    {
        if ($this->permissions != null)
            $this->permissions = array_unique($this->permissions);
        return parent::beforeValidate();
    }
    
    /**
     * Validation rule.
     * Check auth items existence.
     * @param string $attribute attribute name.
     * @param array $params additional params.
     */
    public function permissionsRule($attribute,$params)
    {
        $foundCount = count(AuthItem::model()->findAllByPk($this->permissions));
        if ($foundCount <= 0 || !is_array($this->permissions))
            $this->addError($attribute,Yii::t('users','model.user.error.permissions'));
        if (count($this->permissions) != $foundCount)
            $this->addError($attribute,Yii::t('users','model.user.error.permissions'));
    }
    
    /**
     * Return static model of User.
     * @param string $className current class name.
     * @return User object.
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    /**
     * Model database table name.
     * @return string table name.
     */
    public function tableName(){
        return '{{user}}';
    }
    
    /**
     * Model relations.
     * Relations:
     *     assignments - auth items assignments;
     *     items - current user auth items;
     *     profile - user profile;
     *     pm - user personal messages.
     * @return array relations.
     */
    public function relations(){
        return array(
            'assignments' => array(self::HAS_MANY,'AuthAssignment','userid'),
            'items' => array(self::HAS_MANY,'AuthItem',array('itemname' => 'name'),'through' => 'assignments'),
            'profile' => array(self::HAS_ONE,'Profile','userid'),
            'pm' => array(self::HAS_MANY,'Pm','ownerid')
        );
    }
}
?>