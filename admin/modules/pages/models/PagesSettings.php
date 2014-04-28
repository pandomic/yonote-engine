<?php
class PagesSettings extends CFormModel
{
    public $adminPagesPageSize;
    public $aliasLengthMax;
    public $aliasLengthMin;
    public $titleLengthMin;
    public $titleLengthMax;
    
    private $_settings = array();
    private $_relations = array();

    public function rules()
    {
        return array(
            array(
                'adminPagesPageSize,aliasLengthMax,aliasLengthMin,titleLengthMin,titleLengthMax',
                'required',
                'message' => Yii::t('PagesModule.settings','model.pagessettings.error.required')
            ),
            array(
                'adminPagesPageSize,aliasLengthMax,aliasLengthMin,titleLengthMin,titleLengthMax','numerical','integerOnly' => true,'min' => 1,
                'tooSmall' =>  Yii::t('PagesModule.settings','model.pagessettings.error.small'),
                'message' => Yii::t('PagesModule.settings','model.pagessettings.error.integer')
            )
        );
    }
    
    public function save()
    {
        if (!$this->validate())
            return false;
        foreach ($this->_relations as $k => $v)
        {
            $model = Setting::model()->find('name=:name AND category=:cat',array(
                ':name' => $k,
                ':cat' => 'pages'
            ));
            if ($model !== null)
            {
                $model->setAttribute('value',$this->{$v});
                $model->save();
            }
        }
        return true;
    }
    
    public function attributeLabels()
    {
        $labels = array();
        foreach ($this->_relations as $k => $v)
            $labels[$v] = Yii::t('PagesModule.settings',$this->_settings[$k]->description);
        return $labels;
    }

    public function init()
    {
        $this->_relations = array(
            'admin.pages.page.size' => 'adminPagesPageSize',
            'alias.length.min' => 'aliasLengthMin',
            'alias.length.max' => 'aliasLengthMax',
            'title.length.min' => 'titleLengthMin',
            'title.length.max' => 'titleLengthMax'
        );
        
        $criteria = new CDbCriteria();
        $criteria->params = array(':category' => 'pages');
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