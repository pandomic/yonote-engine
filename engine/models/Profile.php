<?php
class Profile extends CActiveRecord
{
    public $userid;
    public $photo;
    public $name;
    public $country;
    public $city;
    public $language;
    public $removePhoto;
    public $updatetime;
    
    public function behaviors()
    {
        return array(
            'LanguagesBehavior' => array(
                'class' => 'LanguagesBehavior'
            ),
            'ImageBehavior' => array(
                'class' => 'ImageBehavior',
                'fileField' => 'photo',
                'savePath' => UPLOADS_PATH.'/photos',
                'checkSides' => true,
                'minWidth' => (int) Yii::app()->settings->get('user','profile.photo.width.min'),
                'minHeight' => (int) Yii::app()->settings->get('user','profile.photo.height.min'),
                'maxWidth' => (int) Yii::app()->settings->get('user','profile.photo.width.max'),
                'maxHeight' => (int) Yii::app()->settings->get('user','profile.photo.height.max'),
                'resizeImage' => Yii::app()->settings->get('user','profile.photo.resize.enabled',true),
                'cropOnResize' => true,
                'resizeWidth' => (int) Yii::app()->settings->get('user','profile.photo.resize.width'),
                'resizeHeight' => (int) Yii::app()->settings->get('user','profile.photo.resize.height'),
                'quality' => (int) Yii::app()->settings->get('user','profile.photo.quality')
            )
        );
    }

    public function rules(){

        return array(
            array('removePhoto','boolean'),
            array(
                'userid','exist','allowEmpty' => false,'className' => 'User','attributeName' => 'name',
                'message' => ''
            ),
            array(
                'photo','file','types' => 'jpg,jpeg,gif,png','allowEmpty' => true,
                'maxSize' => Yii::app()->settings->get('user','profile.photo.size.max'),
                'tooLarge' => Yii::t('users','model.profile.error.photo.size.large'),
                'tooMany' => Yii::t('users','model.profile.error.photo.many'),
                'wrongType' => Yii::t('users','model.profile.error.photo.type')
            ),
            array(
                'name,country,city','match','pattern' => '/\w+/iu',
                'message' => Yii::t('users','model.profile.error.fields.match')
            ),
            array (
                'name,country,city','length',
                'min' => Yii::app()->settings->get('user','profile.fields.length.min'),
                'max' => Yii::app()->settings->get('user','profile.fields.length.max'),
                'tooLong' => Yii::t('users','model.profile.error.fields.length.long'),
                'tooShort' => Yii::t('users','model.profile.error.fields.length.short')
            ),
            array('language','languageRule')
        );
    }
    
    public function languageRule($attribute,$params)
    {
        if ($this->getAttribute($attribute) != null)
            if (!in_array($this->getAttribute($attribute),array_keys($this->getLanguages())))
                $this->addError($attribute,Yii::t('users','model.profile.error.language'));
    }
    
    public function beforeSave()
    {
        $this->updatetime = time();
        $oldPhoto = $this->findByPk($this->userid)->photo;

        $image = $this->processImage();
        if ($image === false && $this->getImageError() != ImageBehavior::ERROR_FILE_EMPTY){
            $status = $this->getImageError();

            $minWidth = Yii::app()->settings->get('user','profile.photo.width.min');
            $maxWidth = Yii::app()->settings->get('user','profile.photo.width.max');
            $minHeight = Yii::app()->settings->get('user','profile.photo.height.min');
            $maxHeight = Yii::app()->settings->get('user','profile.photo.height.max');

            if ($status == ImageBehavior::ERROR_SIDES_BIG)
                $this->addError('photo',Yii::t('users','model.profile.error.photo.sides.large',array(
                    '{maxwidth}' => $maxWidth,'{maxheight}' => $maxHeight
                )));
            else if ($status == ImageBehavior::ERROR_SIDES_SMALL)
                $this->addError('photo',Yii::t('users','model.profile.error.photo.sides.small',array(
                    '{minwidth}' => $minWidth,'{minheight}' => $minHeight
                )));
            return false;
        }
        else if ($image !== false)
        {
            if ($oldPhoto != null && file_exists(UPLOADS_PATH.'/'.$oldPhoto))
                unlink(UPLOADS_PATH.'/'.$oldPhoto);
            $this->photo = 'photos/'.$image;
        }

        if ($this->removePhoto)
        {
            $this->photo = null;
            if ($oldPhoto != null && file_exists(UPLOADS_PATH.'/'.$oldPhoto))
                unlink(UPLOADS_PATH.'/'.$oldPhoto);
        }

        return parent::beforeSave();
    }

    public function attributeLabels()
    {
        return array(
            'photo' => Yii::t('users','model.profile.photo'),
            'name' => Yii::t('users','model.profile.name'),
            'country' => Yii::t('users','model.profile.country'),
            'city' => Yii::t('users','model.profile.city'),
            'language' => Yii::t('users','model.profile.language'),
            'removePhoto' => Yii::t('users','model.profile.removephoto'),
        );
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{profile}}';
    }
    
    public function getPhoto()
    {
        $return = false;
        if ($this->photo != null)
            if (file_exists(UPLOADS_PATH.'/'.$this->photo))
                $return = UPLOADS_PATH_URI."/{$this->photo}";
        return $return;
    }
}
?>