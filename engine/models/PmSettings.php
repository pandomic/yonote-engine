<?php
/**
 * PmSettings class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

/**
 * This model class allows to manage pm configuration.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class PmSettings extends CFormModel
{
    /**
     * @var string maximum message length
     */
    public $messageLengthMax;
    /**
     * @var string minimum message length
     */
    public $messageLengthMin;
    /**
     * @var string minimum message title length
     */
    public $titleLengthMin;
    /**
     * @var string maximum message title length
     */
    public $titleLengthMax;
    
    private $_settings = array();
    private $_relations = array();

    /**
     * Validation rules.
     * @return array validation rules.
     */
    public function rules()
    {
        return array(
            array(
                'messageLengthMax,messageLengthMin,titleLengthMin,titleLengthMax',
                'required',
                'message' => Yii::t('pm','model.pmsettings.error.required')
            ),
            array(
                'messageLengthMax,messageLengthMin,titleLengthMin,titleLengthMax','numerical','min' => 1,
                'tooSmall' => Yii::t('pm','model.pmsettings.error.small'),
                'message' => Yii::t('pm','model.pmsettings.error.integer')
            )
        );
    }
    
    /**
     * Save pm configuration.
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
                ':cat' => 'pm'
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
     * Attribute labels.
     * @return array attribute labels.
     */
    public function attributeLabels()
    {
        $labels = array();
        foreach ($this->_relations as $k => $v)
            $labels[$v] = Yii::t('pm',$this->_settings[$k]->description);
        return $labels;
    }
    
    /**
     * Load settings parameters to show.
     * @return void.
     */
    public function init()
    {
        $this->_relations = array(
            'message.length.max' => 'messageLengthMax',
            'message.length.min' => 'messageLengthMin',
            'title.length.min' => 'titleLengthMin',
            'title.length.max' => 'titleLengthMax'
        );
        
        $criteria = new CDbCriteria();
        $criteria->params = array(':category' => 'pm');
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