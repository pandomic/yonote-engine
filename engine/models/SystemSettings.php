<?php
class SystemSettings extends CFormModel
{
    public $adminLanguage;
    public $adminTemplate;
    public $websiteLanguage;
    public $websiteTemplate;
    public $adminTimezone;
    public $websiteTimezone;
    public $systemUrlFormat;
    public $systemLoginDuration;
    
    private $_settings = array();
    private $_relations = array();
    private $_templates = array(
        'frontend' => null,
        'backend' => null
    );
    
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

    public function rules()
    {
        return array(
            array(
                'adminTimezone,websiteTimezone,websiteLanguage,websiteTemplate,adminTimezone,websiteTimezone,systemUrlFormat,systemLoginDuration',
                'required',
                'message' => Yii::t('settings','model.systemsettings.error.required')
            ),
            array(
                'systemLoginDuration','numerical','min' => 1,
                'tooSmall' => Yii::t('settings','model.systemsettings.error.small')
            ),
            array(
                'systemUrlFormat','in','range' => array('path','get'),
                'message' => Yii::t('settings','model.systemsettings.error.url.format')
            ),
            array('adminLanguage,websiteLanguage','languageRule'),
            array('adminTemplate','templateRule','area' => 'backend'),
            array('websiteTemplate','templateRule','area' => 'frontend'),
            array('websiteTimezone,adminTimezone','timezoneRule')
        );
    }
    
    public function languageRule($attribute,$params)
    {
        $languages = array_keys($this->getLanguages());
        if (!in_array($this->{$attribute},$languages))
            $this->addError($attribute,Yii::t('settings','model.systemsettings.error.language'));
    }
    
    public function timezoneRule($attribute,$params)
    {
        $timezones = array_keys($this->getTimezones());
        if (!in_array($this->{$attribute},$timezones))
            $this->addError($attribute,Yii::t('settings','model.systemsettings.error.timezone'));
    }
    
    public function templateRule($attribute,$params)
    {
        if (!in_array($this->{$attribute},$this->getTemplates($params['area'])))
            $this->addError($attribute,Yii::t('settings','model.systemsettings.error.template'));
    }

    public function save()
    {
        if (!$this->validate())
            return false;
        foreach ($this->_relations as $k => $v)
        {
            $model = Setting::model()->find('name=:name',array(':name' => $k));
            if ($model !== null)
            {
                $model->setAttribute('value',$this->{$v});
                $model->save();
            }
                
        }
        return true;
    }
    
    public function getUrlFormats()
    {
        return array(
            'path' => Yii::t('settings','label.url.format.path'),
            'get' => Yii::t('settings','label.url.format.get')
        );
    }
    
    public function getTemplates($area)
    {
        if ($this->_templates[$area] !== null)
            return $this->_templates[$area];
        if ($area == 'frontend')
            $alias = 'application.templates';
        else
            $alias = 'admin.templates';
        $this->_templates[$area] = scandir(Yii::getPathOfAlias($alias));
        array_shift($this->_templates[$area]); // Remove ./
        array_shift($this->_templates[$area]); // Remove ../
        $this->_templates[$area] = array_combine(
            $this->_templates[$area],
            $this->_templates[$area]
        );
        return $this->_templates[$area];
    }
    
    public function attributeLabels()
    {
        $labels = array();
        foreach ($this->_relations as $k => $v)
            $labels[$v] = Yii::t('settings',$this->_settings[$k]->description);
        return $labels;
    }

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
            'login.duration' => 'systemLoginDuration'
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