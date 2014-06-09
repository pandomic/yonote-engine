<?php
class FirstStep extends CFormModel
{
    public $insLang;
    
    public function rules()
    {
        return array(
            array('insLang','installationLanguageRule')
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'insLang' => Yii::t('installation','model.firststep.inslang')
        );
    }


    public function installationLanguageRule($attribute,$params)
    {
        if (!in_array($this->{$attribute},array_keys($this->getInstallationLanguages())))
            $this->addError($attribute,'Invalid language');
    }

    public function getSystemLanguages()
    {
        $languages = array();
        $scan = scandir(realpath(dirname(__FILE__).'/../../engine/messages'));
        foreach ($scan as $language)
        {
            if ($language != '.' && $language != '..')
                $languages[$language] = $language;
        }
        return $languages;
    }
    
    public function getInstallationLanguages()
    {
        $languages = array();
        $scan = scandir(realpath(dirname(__FILE__).'/../messages'));
        foreach ($scan as $language)
        {
            if ($language != '.' && $language != '..')
                $languages[$language] = $language;
        }
        return $languages;
    }
}
?>