<?php
class Setting extends CActiveRecord
{
    
    public $updatetime;
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
 
    public function tableName()
    {
        return '{{setting}}';
    }
    
    public function beforeSave()
    {
        $this->updatetime = time();
        return parent::beforeSave();
    }
}
?>