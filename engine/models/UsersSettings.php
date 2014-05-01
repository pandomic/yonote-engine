<?php
/**
 * UsersSettings class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

/**
 * This model class allows to manage users configuration.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class UsersSettings extends CFormModel
{
    /**
     * @var integer user name minimum length.
     */
    public $nameLengthMin;
    /**
     * @var integer user name maximum length.
     */
    public $nameLengthMax;
    /**
     * @var integer user password minimum length.
     */
    public $passwordLengthMin;
    /**
     * @var integer user password maximum length.
     */
    public $passwordLengthMax;
    /**
     * @var integer user additional profile fields minimum length.
     */
    public $fieldsLengthMin;
    /**
     * @var integer user additional profile fields maximum length.
     */
    public $fieldsLengthMax;
    /**
     * @var integer user photo minimum height.
     */
    public $photoHeightMin;
    /**
     * @var integer user photo maximum height.
     */
    public $photoHeightMax;
    /**
     * @var integer user photo quality.
     */
    public $photoQuality;
    /**
     * @var boolean resize user photo.
     */
    public $photoResizeEnabled;
    /**
     * @var integer resize height.
     */
    public $photoResizeHeight;
    /**
     * @var integer resize width.
     */
    public $photoResizeWidth;
    /**
     * @var integer photo maximum size.
     */
    public $photoSizeMax;
    /**
     * @var integer photo minimum width.
     */
    public $photoWidthMin;
    /**
     * @var integer photo maximum width.
     */
    public $photoWidthMax;
    /**
     * @var integer role description minimum length.
     */
    public $roleDescriptionLengthMin;
    /**
     * @var integer role description maximum length.
     */
    public $roleDescriptionLengthMax;
    /**
     * @var integer role name minimum length.
     */
    public $roleNameLengthMin;
    /**
     * @var integer role name maximum length.
     */
    public $roleNameLengthMax;
    /**
     * @var integer show users per page.
     */
    public $usersPageSize;
    
    private $_settings = array();
    private $_relations = array();
    
    /**
     * Validation rules.
     * @return array validation rules.
     */
    public function rules()
    {
        return array(
            array('photoResizeEnabled','boolean'),
            array(
                'nameLengthMin,nameLengthMax,passwordLengthMin,passwordLengthMax,fieldsLengthMin,fieldsLengthMax,photoHeightMin,photoHeightMax,photoQuality,photoResizeEnabled,photoResizeHeight,photoResizeWidth,photoSizeMax,photoWidthMin,photoWidthMax,roleDescriptionLengthMin,roleDescriptionLengthMax,roleNameLengthMin,roleNameLengthMax,usersPageSize',
                'required',
                'message' => Yii::t('users','model.userssettings.error.required')
            ),
            array(
                'nameLengthMin,nameLengthMax,fieldsLengthMin,fieldsLengthMax,photoHeightMin,photoHeightMax,photoResizeHeight,photoResizeWidth,photoSizeMax,photoWidthMin,photoWidthMax,roleDescriptionLengthMin,roleDescriptionLengthMax,roleNameLengthMin,roleNameLengthMax,usersPageSize','numerical','integerOnly' => true,'min' => 1,
                'tooSmall' =>  Yii::t('users','model.userssettings.error.small'),
                'message' => Yii::t('users','model.userssettings.error.integer')
            ),
            array(
                'passwordLengthMin,passwordLengthMax','numerical','integerOnly' => true,'min' => 6,
                'tooSmall' => Yii::t('users','model.userssettings.error.small'),
                'message' => Yii::t('users','model.userssettings.error.integer')
            ),
            array(
                'photoQuality','numerical','integerOnly' => true,'min' => 1, 'max' => 100,
                'tooSmall' => Yii::t('users','model.userssettings.error.small'),
                'tooBig' => Yii::t('users','model.userssettings.error.big'),
                'message' => Yii::t('users','model.userssettings.error.integer')
            )
        );
    }
    
    /**
     * Save pm configuration.
     * @return boolean save is successfull.
     */
    public function save()
    {
        if (!$this->validate())
            return false;
        foreach ($this->_relations as $k => $v)
        {
            $model = Setting::model()->find('name=:name AND category=:cat',array(
                ':name' => $k,
                ':cat' => 'users'
            ));
            if ($model !== null)
            {
                $model->setAttribute('value',$this->{$v});
                $model->save();
            }
        }
        return true;
    }
    
    /**
     * Attribute labels.
     * @return array attribute labels.
     */
    public function attributeLabels()
    {
        $labels = array();
        foreach ($this->_relations as $k => $v)
            $labels[$v] = Yii::t('users',$this->_settings[$k]->description);
        return $labels;
    }
    
    /**
     * Load settings parameters to show.
     * @return void.
     */
    public function init()
    {
        $this->_relations = array(
            'name.length.min' => 'nameLengthMin',
            'name.length.max' => 'nameLengthMax',
            'password.length.min' => 'passwordLengthMin',
            'password.length.max' => 'passwordLengthMax',
            'profile.fields.length.min' => 'fieldsLengthMin',
            'profile.fields.length.max' => 'fieldsLengthMax',
            'profile.photo.height.min' => 'photoHeightMin',
            'profile.photo.height.max' => 'photoHeightMax',
            'profile.photo.quality' => 'photoQuality',
            'profile.photo.resize.enabled' => 'photoResizeEnabled',
            'profile.photo.resize.height' => 'photoResizeHeight',
            'profile.photo.resize.width' => 'photoResizeWidth',
            'profile.photo.size.max' => 'photoSizeMax',
            'profile.photo.width.min' => 'photoWidthMin',
            'profile.photo.width.max' => 'photoWidthMax',
            'role.description.length.min' => 'roleDescriptionLengthMin',
            'role.description.length.max' => 'roleDescriptionLengthMax',
            'role.name.length.min' => 'roleNameLengthMin',
            'role.name.length.max' => 'roleNameLengthMax',
            'users.page.size' => 'usersPageSize'
        );
        
        $criteria = new CDbCriteria();
        $criteria->params = array(':category' => 'users');
        $criteria->addInCondition('name',array_keys($this->_relations));
        $criteria->addCondition('category=:category');
        
        $settings = Setting::model()->findAll($criteria);

        foreach ($settings as $rec)
        {
            if (isset($this->_relations[$rec->name]))
                $this->{$this->_relations[$rec->name]} = $rec->value;
            $this->_settings[$rec->name] = $rec;
        }
    }
}
?>