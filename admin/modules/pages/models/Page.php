<?php
class Page extends CActiveRecord
{
    
    public $alias;
    public $title;
    public $content;
    public $language;
    
    public function behaviors()
    {
        return array(
            'LanguagesBehavior' => array(
                'class' => 'LanguagesBehavior'
            )
        );
    }
    
    public function rules()
    {
        return array(
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
    
    public function attributeLabels()
    {
        return array(
            'alias' => Yii::t('PagesModule.pages','model.page.alias'),
            'title' => Yii::t('PagesModule.pages','model.page.title'),
            'content' => Yii::t('PagesModule.pages','model.page.content'),
            'language' => Yii::t('PagesModule.pages','model.page.language')
        );
    }

    public function tableName()
    {
        return '{{mod_page}}';
    }
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function languageRule($attribute,$params)
    {
        if ($this->language != null)
        {
            if (!in_array($this->language,array_keys($this->getLanguages())))
                $this->addError ($attribute,Yii::t('PagesModule.pages','model.page.error.language'));
        }
    }
}
?>