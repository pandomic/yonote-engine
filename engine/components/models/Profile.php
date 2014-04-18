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

    private $_languages = null;

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
            if (!in_array($this->getAttribute($attribute),array_keys($this->languages())))
                $this->addError($attribute,Yii::t('users','model.profile.error.language'));
    }
    
    public function beforeSave()
    {
        $this->photo = CUploadedFile::getInstance(self::model(),'photo');
        $oldPhoto = str_replace(
            '{uploads}',UPLOADS_PATH,self::model()->findByPk($this->userid)->photo
        );
        if ($this->photo != null)
        {
            $w = 0;
            $h = 0;

            $image = new CImage($this->photo->getTempName());
            list($w,$h) = $image->sides();

            $minWidth = Yii::app()->settings->get('user','profile.photo.width.min');
            $maxWidth = Yii::app()->settings->get('user','profile.photo.width.max');
            $minHeight = Yii::app()->settings->get('user','profile.photo.height.min');
            $maxHeight = Yii::app()->settings->get('user','profile.photo.height.max');

            if ($w < $minWidth || $h < $minHeight)
            {
                $this->addError('photo',Yii::t('users','model.profile.error.photo.sides.small',array(
                    '{minwidth}' => $minWidth,'{minheight}' => $minHeight
                )));
                return false;
            }
            else if ($w > $maxWidth || $h > $maxHeight)
            {
                $this->addError('photo',Yii::t('users','model.profile.error.photo.sides.large',array(
                    '{maxwidth}' => $maxWidth,'{maxheight}' => $maxHeight
                )));
                return false;
            }
            else
            {
                $name = uniqid();
                $path = "photos/{$name}.{$this->photo->getExtensionName()}";
                if (Yii::app()->settings->get('user','profile.photo.resize.enabled',true))
                    $image->resize(
                        (int) Yii::app()->settings->get('user','profile.photo.resize.width'),
                        (int) Yii::app()->settings->get('user','profile.photo.resize.height'),
                        true
                    );
                $image->save(
                    $image->mime(),UPLOADS_PATH."/{$path}",
                    (int) Yii::app()->settings->get('user','profile.photo.quality')
                );
                if (file_exists($oldPhoto))
                    unlink($oldPhoto);
                $this->photo = "{uploads}/{$path}";
            }
        }
        else if ($this->photo == null && !$this->removePhoto)
            $this->photo = self::model()->findByPk($this->userid)->photo;
        else if ($this->removePhoto)
        {
            $this->photo = null;
            if (file_exists($oldPhoto))
                unlink($oldPhoto);
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
    
    public function languages()
    {
        if ($this->_languages === null)
        {
            $this->_languages = array();
            $locale = CLocale::getInstance(Yii::app()->getLanguage());
            $ids = $locale->getLocaleIDs();
            foreach ($ids as $name)
                if (($language = $locale->getLocaleDisplayName($name)) !== null)
                    $this->_languages[$name] = "{$language} ({$name})";
        }
        return $this->_languages;
    }

    public function tableName()
    {
        return '{{profile}}';
    }
}
?>