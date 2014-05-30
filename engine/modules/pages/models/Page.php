<?php
/**
 * Page class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

/**
 * Page model is used to manage single pages records.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class Page extends CActiveRecord
{
    /**
     * @var string page alias.
     */
    public $alias;
    /**
     * @var string page title.
     */
    public $title;
    /**
     * @var string page content.
     */
    public $content;
    /**
     * @var string page language.
     */
    public $language;
    
    public $thumbnail;
    public $removeThumbnail;
    
    /**
     * Attached behaviors.
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
                'fileField' => 'thumbnail',
                'savePath' => UPLOADS_PATH.'/images',
                'checkSides' => true,
                'minWidth' => (int) Yii::app()->settings->get('pages','thumbnail.width.min'),
                'minHeight' => (int) Yii::app()->settings->get('pages','thumbnail.height.min'),
                'maxWidth' => (int) Yii::app()->settings->get('pages','thumbnail.width.max'),
                'maxHeight' => (int) Yii::app()->settings->get('pages','thumbnail.height.max'),
                'resizeImage' => Yii::app()->settings->get('pages','thumbnail.resize.enabled',true),
                'cropOnResize' => true,
                'resizeWidth' => (int) Yii::app()->settings->get('pages','thumbnail.resize.width'),
                'resizeHeight' => (int) Yii::app()->settings->get('pages','thumbnail.resize.height'),
                'quality' => (int) Yii::app()->settings->get('pages','thumbnail.quality')
            )
        );
    }
    
    /**
     * Validation rules.
     * @return array of rules.
     */
    public function rules()
    {
        return array(
            array('content','filter','filter' => array($obj = new CHtmlPurifier(),'purify')),
            array(
                'alias,title','required',
                'message' => Yii::t('PagesModule.pages','model.page.error.required')
            ),
            array(
                'alias','unique',
                'message' => Yii::t('PagesModule.pages','model.page.error.alias.unique')
            ),
            array(
                'alias','length',
                'min' => Yii::app()->settings->get('pages','alias.length.min'),
                'max' => Yii::app()->settings->get('pages','alias.length.max'),
                'tooShort' => Yii::t('PagesModule.pages','model.page.error.alias.short'),
                'tooLong' => Yii::t('PagesModule.pages','model.page.error.alias.long')
            ),
            array(
                'title','length',
                'min' => Yii::app()->settings->get('pages','title.length.min'),
                'max' => Yii::app()->settings->get('pages','title.length.max'),
                'tooShort' => Yii::t('PagesModule.pages','model.page.error.title.short'),
                'tooLong' => Yii::t('PagesModule.pages','model.page.error.title.long')
            ),
            array(
                'alias','match','pattern' => '/^(?:[a-z0-9_]+-?)+[a-z0-9_]$/i',
                'message' => Yii::t('PagesModule.pages','model.page.error.alias.match')
            ),
            array(
                'title','match','pattern' => '/^[\w\s.,\-!?:@]+$/iu',
                'message' => Yii::t('PagesModule.pages','model.page.error.title.match')
            ),
            array(
                'thumbnail','file','types' => 'jpg,jpeg,gif,png','allowEmpty' => true,
                'maxSize' => Yii::app()->settings->get('pages','thumbnail.size.max'),
                'tooLarge' => Yii::t('PagesModule.pages','model.page.error.thumbnail.size.large'),
                'tooMany' => Yii::t('PagesModule.pages','model.page.error.thumbnail.many'),
                'wrongType' => Yii::t('PagesModule.pages','model.page.error.thumbnail.type')
            ),
            array('language','languageRule'),
            array('content','safe'),
            array('alias','filter','filter'=>'mb_strtolower'),
            array('removeThumbnail','boolean')
        );
    }
    
    /**
     * Setup attribute labels.
     * @return array of attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'alias' => Yii::t('PagesModule.pages','model.page.alias'),
            'title' => Yii::t('PagesModule.pages','model.page.title'),
            'content' => Yii::t('PagesModule.pages','model.page.content'),
            'language' => Yii::t('PagesModule.pages','model.page.language'),
            'thumbnail' => Yii::t('PagesModule.pages','model.page.thumbnail'),
            'removeThumbnail' => Yii::t('PagesModule.pages','model.page.removethumbnail')
        );
    }
    
    /**
     * Cpecify the ActiveRecord table name.
     * @return string table name.
     */
    public function tableName()
    {
        return '{{mod_page}}';
    }
    
    /**
     * Return static model of Pm.
     * @param string $className current class name.
     * @return Pm object.
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    /**
     * Validation rule.
     * Check language.
     * @param string $attribute attribute name.
     * @param array $params additional params.
     * @return void.
     */
    public function languageRule($attribute,$params)
    {
        if ($this->language != null)
        {
            if (!in_array($this->language,array_keys($this->getLanguages())))
                $this->addError ($attribute,Yii::t('PagesModule.pages','model.page.error.language'));
        }
    }
    
    /**
     * Action, that will be executed before model will be saved.
     * Update the update time.
     * @return boolean parent::beforeSave() status.
     */
    public function beforeSave()
    {
        $this->updatetime = time();
        $oldThumbnail = $this->findByPk($this->alias)->thumbnail;
        $image = $this->processImage();
        if ($image === false && $this->getImageError() != ImageBehavior::ERROR_FILE_EMPTY){
            $status = $this->getImageError();

            $minWidth = Yii::app()->settings->get('pages','thumbnail.width.min');
            $maxWidth = Yii::app()->settings->get('pages','thumbnail.width.max');
            $minHeight = Yii::app()->settings->get('pages','thumbnail.height.min');
            $maxHeight = Yii::app()->settings->get('pages','thumbnail.height.max');

            if ($status == ImageBehavior::ERROR_SIDES_BIG)
                $this->addError('thumbnail',Yii::t('PagesModule.pages','model.page.error.thumbnail.sides.large',array(
                    '{maxwidth}' => $maxWidth,'{maxheight}' => $maxHeight
                )));
            else if ($status == ImageBehavior::ERROR_SIDES_SMALL)
                $this->addError('thumbnail',Yii::t('PagesModule.pages','model.page.error.thumbnail.sides.small',array(
                    '{minwidth}' => $minWidth,'{minheight}' => $minHeight
                )));
            return false;
        }
        else if ($image !== false)
        {
            if ($oldThumbnail != null && file_exists(UPLOADS_PATH.'/'.$oldThumbnail))
                unlink(UPLOADS_PATH.'/'.$oldThumbnail);
            $this->thumbnail = 'images/'.$image;
        }
        
        if ($this->removeThumbnail)
        {
            $this->thumbnail = null;
            if ($oldThumbnail != null && file_exists(UPLOADS_PATH.'/'.$oldThumbnail))
                unlink(UPLOADS_PATH.'/'.$oldThumbnail);
        }
        return parent::beforeSave();
    }
}
?>