<?php
/**
 * SystemSettings class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

/**
 * This model class allows to manage system configuration.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class SystemSettings extends CFormModel
{
    /**
     * @var string administrative panel language
     */
    public $adminLanguage;
    /**
     * @var string administrative panel template
     */
    public $adminTemplate;
    /**
     * @var string website language
     */
    public $websiteLanguage;
    /**
     * @var string website template
     */
    public $websiteTemplate;
    /**
     * @var string administrative panel php-timezone
     */
    public $adminTimezone;
    /**
     * @var string website php-timezone
     */
    public $websiteTimezone;
    /**
     * @var string system URL format
     */
    public $systemUrlFormat;
    /**
     * @var string user login duration
     */
    public $systemLoginDuration;
    /**
     * @var string maximum module file size
     */
    public $moduleMaxSize;
    /**
     * @var string allowed languages list (separated by comma)
     */
    public $allowedLanguages;
    /**
     * @var boolean allow to use and form multilingual URLs.
     */
    public $allowMultilingualUrls = false;
    /**
     * @var boolean redirect to default language version if null given.
     */
    public $redirectDefault = false;
    
    private $_settings = array();
    private $_relations = array();
    private $_templates = array(
        'frontend' => null,
        'backend' => null
    );
    
    /**
     * Attach some behaviors.
     * @return array behaviors.
     */
    public function behaviors()
    {
        return array(
            'TimezonesBehavior' => array(
                'class' => 'TimezonesBehavior'
            ),
            'LanguagesBehavior' => array(
                'class' => 'LanguagesBehavior'
            )
        );
    }
    
    /**
     * Validation rules.
     * @return array validation rules.
     */
    public function rules()
    {
        return array(
            array(
                'adminTimezone,websiteTimezone,websiteLanguage,websiteTemplate,adminTimezone,websiteTimezone,systemUrlFormat,systemLoginDuration,moduleMaxSize',
                'required',
                'message' => Yii::t('settings','model.systemsettings.error.required')
            ),
            array(
                'systemLoginDuration,moduleMaxSize','numerical','min' => 1,
                'tooSmall' => Yii::t('settings','model.systemsettings.error.small'),
                'message' => Yii::t('settings','model.systemsettings.error.integer')
            ),
            array(
                'systemUrlFormat','in','range' => array('path','get'),
                'message' => Yii::t('settings','model.systemsettings.error.url.format')
            ),
            array(
                'allowedLanguages','match','pattern' => '/^([a-z]{2,3},?)*[a-z]{2,3}$/',
                'message' => Yii::t('settings','model.systemsettings.error.allowedlanguages')
            ),
            array('redirectDefault,allowMultilingualUrls','boolean'),
            array('adminLanguage,websiteLanguage','languageRule'),
            array('adminTemplate','templateRule','area' => 'backend'),
            array('websiteTemplate','templateRule','area' => 'frontend'),
            array('websiteTimezone,adminTimezone','timezoneRule')
        );
    }
    
    /**
     * Validation rule.
     * Check if given language exists.
     * @param string $attribute attribute name.
     * @param array $params additional params.
     */
    public function languageRule($attribute,$params)
    {
        $languages = array_keys($this->getLanguages());
        if (!in_array($this->{$attribute},$languages))
            $this->addError($attribute,Yii::t('settings','model.systemsettings.error.language'));
    }
    
    /**
     * Validation rule.
     * Check if given timezone exists.
     * @param string $attribute attribute name.
     * @param array $params additional params.
     */
    public function timezoneRule($attribute,$params)
    {
        $timezones = array_keys($this->getTimezones());
        if (!in_array($this->{$attribute},$timezones))
            $this->addError($attribute,Yii::t('settings','model.systemsettings.error.timezone'));
    }
    
    /**
     * Validation rule.
     * Check if given template exists.
     * @param string $attribute attribute name.
     * @param array $params additional params.
     */
    public function templateRule($attribute,$params)
    {
        if (!in_array($this->{$attribute},$this->getTemplates($params['area'])))
            $this->addError($attribute,Yii::t('settings','model.systemsettings.error.template'));
    }
    
    /**
     * Save system configuration.
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
                ':cat' => 'system'
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
     * Get allowed URL formats.
     * @return array URL formats.
     */
    public function getUrlFormats()
    {
        return array(
            'path' => Yii::t('settings','label.url.format.path'),
            'get' => Yii::t('settings','label.url.format.get')
        );
    }
    
    /**
     * Return templates list for specified area (frontend or backend).
     * @param string $area area (frontend or backend).
     * @return array templates list.
     */
    public function getTemplates($area)
    {
        if ($this->_templates[$area] !== null)
            return $this->_templates[$area];
        if ($area == 'frontend')
            $alias = 'application.templates';
        else
            $alias = 'admin.templates';
        $this->_templates[$area] = scandir(Yii::getPathOfAlias($alias));
        foreach ($this->_templates[$area] as $k => $template)
        {
            if (!is_dir(Yii::getPathOfAlias($alias).'/'.$template) || $template == '.' || $template == '..')
                unset($this->_templates[$area][$k]);
        }
        $this->_templates[$area] = array_combine(
            $this->_templates[$area],
            $this->_templates[$area]
        );
        return $this->_templates[$area];
    }
    
    /**
     * Attribute labels.
     * @return array attribute labels.
     */
    public function attributeLabels()
    {
        $labels = array();
        foreach ($this->_relations as $k => $v)
            $labels[$v] = Yii::t('settings',$this->_settings[$k]->description);
        return $labels;
    }
    
    /**
     * Load settings parameters to show.
     * @return void.
     */
    public function init()
    {
        $this->_relations = array(
            'admin.language' => 'adminLanguage',
            'admin.template' => 'adminTemplate',
            'website.language' => 'websiteLanguage',
            'website.template' => 'websiteTemplate',
            'admin.time.zone' => 'adminTimezone',
            'website.time.zone' => 'websiteTimezone',
            'url.format' => 'systemUrlFormat',
            'login.duration' => 'systemLoginDuration',
            'module.size.max' => 'moduleMaxSize',
            'languages' => 'allowedLanguages',
            'url.redirectondefault' => 'redirectDefault',
            'url.multilingual' => 'allowMultilingualUrls'
        );
        
        $criteria = new CDbCriteria();
        $criteria->params = array(':category' => 'system');
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