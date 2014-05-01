<?php
/**
 * Profile class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

/**
 * Profile model class.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class Profile extends CActiveRecord
{
    /**
     * @var string user id.
     */
    public $userid;
    /**
     * @var string user photo.
     */
    public $photo;
    /**
     * @var string user name.
     */
    public $name;
    /**
     * @var string user country.
     */
    public $country;
    /**
     * @var string user city.
     */
    public $city;
    /**
     * @var string user language.
     */
    public $language;
    /**
     * @var boolean remove photo.
     */
    public $removePhoto;
    
    /**
     * Attach some behaviors.
     * @return array behaviors.
     */
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
                'minWidth' => (int) Yii::app()->settings->get('users','profile.photo.width.min'),
                'minHeight' => (int) Yii::app()->settings->get('users','profile.photo.height.min'),
                'maxWidth' => (int) Yii::app()->settings->get('users','profile.photo.width.max'),
                'maxHeight' => (int) Yii::app()->settings->get('users','profile.photo.height.max'),
                'resizeImage' => Yii::app()->settings->get('users','profile.photo.resize.enabled',true),
                'cropOnResize' => true,
                'resizeWidth' => (int) Yii::app()->settings->get('users','profile.photo.resize.width'),
                'resizeHeight' => (int) Yii::app()->settings->get('users','profile.photo.resize.height'),
                'quality' => (int) Yii::app()->settings->get('users','profile.photo.quality')
            )
        );
    }
    
    /**
     * Validation rules.
     * @return array validation rules.
     */
    public function rules(){

        return array(
            array('removePhoto','boolean'),
            array(
                'userid','exist','allowEmpty' => false,'className' => 'User','attributeName' => 'name',
                'message' => ''
            ),
            array(
                'photo','file','types' => 'jpg,jpeg,gif,png','allowEmpty' => true,
                'maxSize' => Yii::app()->settings->get('users','profile.photo.size.max'),
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
                'min' => Yii::app()->settings->get('users','profile.fields.length.min'),
                'max' => Yii::app()->settings->get('users','profile.fields.length.max'),
                'tooLong' => Yii::t('users','model.profile.error.fields.length.long'),
                'tooShort' => Yii::t('users','model.profile.error.fields.length.short')
            ),
            array('language','languageRule')
        );
    }
    
    /**
     * Validation rule.
     * Check language.
     * @param string $attribute attribute name.
     * @param array $params additional params.
     */
    public function languageRule($attribute,$params)
    {
        if ($this->getAttribute($attribute) != null)
            if (!in_array($this->getAttribute($attribute),array_keys($this->getLanguages())))
                $this->addError($attribute,Yii::t('users','model.profile.error.language'));
    }
    
    /**
     * Action, that will be executed before model will be saved.
     * Upload and process module archive.
     * @return boolean parent beforeSave() status.
     */
    public function beforeSave()
    {
        $this->updatetime = time();
        $oldPhoto = $this->findByPk($this->userid)->photo;

        $image = $this->processImage();
        if ($image === false && $this->getImageError() != ImageBehavior::ERROR_FILE_EMPTY){
            $status = $this->getImageError();

            $minWidth = Yii::app()->settings->get('users','profile.photo.width.min');
            $maxWidth = Yii::app()->settings->get('users','profile.photo.width.max');
            $minHeight = Yii::app()->settings->get('users','profile.photo.height.min');
            $maxHeight = Yii::app()->settings->get('users','profile.photo.height.max');

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
    
    /**
     * Attribute labels.
     * @return array attribute labels.
     */
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
    
    /**
     * Return static model of Profile.
     * @param string $className current class name.
     * @return Profile object.
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
        return '{{profile}}';
    }
    
    /**
     * Return user photo path.
     * @return string|boolean user photo path or false, is photo not found.
     */
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