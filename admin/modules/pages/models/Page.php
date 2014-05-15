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
    
    /**
     * Attached behaviors.
     * @return array behaviors.
     */
    public function behaviors()
    {
        return array(
            'LanguagesBehavior' => array(
                'class' => 'LanguagesBehavior'
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
            array('language','languageRule'),
            array('content','safe'),
            array('alias','filter','filter'=>'mb_strtolower'),
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
            'language' => Yii::t('PagesModule.pages','model.page.language')
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
        return parent::beforeSave();
    }
}
?>