<?php
class UsersSettings extends CFormModel
{
    public $nameLengthMin;
    public $nameLengthMax;
    public $passwordLengthMin;
    public $passwordLengthMax;
    public $fieldsLengthMin;
    public $fieldsLengthMax;
    public $photoHeightMin;
    public $photoHeightMax;
    public $photoQuality;
    public $photoResizeEnabled;
    public $photoResizeHeight;
    public $photoResizeWidth;
    public $photoSizeMax;
    public $photoWidthMin;
    public $photoWidthMax;
    public $roleDescriptionLengthMin;
    public $roleDescriptionLengthMax;
    public $roleNameLengthMin;
    public $roleNameLengthMax;
    
    private $_settings = array();
    private $_relations = array();
    private $_names = array();

    public function rules()
    {
        return array(
            array('photoResizeEnabled','boolean'),
            array(
                'nameLengthMin,nameLengthMax,passwordLengthMin,passwordLengthMax,fieldsLengthMin,fieldsLengthMax,photoHeightMin,photoHeightMax,photoQuality,photoResizeEnabled,photoResizeHeight,photoResizeWidth,photoSizeMax,photoWidthMin,photoWidthMax,roleDescriptionLengthMin,roleDescriptionLengthMax,roleNameLengthMin,roleNameLengthMax',
                'required',
                'message' => Yii::t('users','model.userssettings.error.required')
            ),
            array(
                'nameLengthMin,nameLengthMax,fieldsLengthMin,fieldsLengthMax,photoHeightMin,photoHeightMax,photoResizeHeight,photoResizeWidth,photoSizeMax,photoWidthMin,photoWidthMax,roleDescriptionLengthMin,roleDescriptionLengthMax,roleNameLengthMin,roleNameLengthMax','numerical','integerOnly' => true,'min' => 1,
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
    
    public function save()
    {
        if (!$this->validate())
            return false;
        foreach ($this->_relations as $k => &$v)
        {
            $model = Setting::model()->find('name=:name',array(':name' => $k));
            if ($model !== null)
            {
                $model->setAttribute('value',$v);
                $model->save();
            }
                
        }
        return true;
    }
    
    public function attributeLabels()
    {
        $labels = array();
        foreach ($this->_names as $k => $v)
            $labels[$v] = $this->_settings[$k]->description;
        return $labels;
    }

        public function init()
    {
        $this->_relations = array(
            'name.length.min' => &$this->nameLengthMin,
            'name.length.max' => &$this->nameLengthMax,
            'password.length.min' => &$this->passwordLengthMin,
            'password.length.max' => &$this->passwordLengthMax,
            'profile.fields.length.min' => &$this->fieldsLengthMin,
            'profile.fields.length.max' => &$this->fieldsLengthMax,
            'profile.photo.height.min' => &$this->photoHeightMin,
            'profile.photo.height.max' => &$this->photoHeightMax,
            'profile.photo.quality' => &$this->photoQuality,
            'profile.photo.resize.enabled' => &$this->photoResizeEnabled,
            'profile.photo.resize.height' => &$this->photoResizeHeight,
            'profile.photo.resize.width' => &$this->photoResizeWidth,
            'profile.photo.size.max' => &$this->photoSizeMax,
            'profile.photo.width.min' => &$this->photoWidthMin,
            'profile.photo.width.max' => &$this->photoWidthMax,
            'role.description.length.min' => &$this->roleDescriptionLengthMin,
            'role.description.length.max' => &$this->roleDescriptionLengthMax,
            'role.name.length.min' => &$this->roleNameLengthMin,
            'role.name.length.max' => &$this->roleNameLengthMax
        );
        
        $this->_names = array(
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
            'role.name.length.max' => 'roleNameLengthMax'
        );
        
        $criteria = new CDbCriteria();
        $criteria->params = array(':category' => 'user');
        $criteria->addInCondition('name',array_keys($this->_relations));
        $criteria->addCondition('category=:category');
        
        $settings = Setting::model()->findAll($criteria);

        foreach ($settings as $rec)
        {
            $this->_relations[$rec->name] = $rec->value;
            $this->_settings[$rec->name] = $rec;
        }
    }
}
?>