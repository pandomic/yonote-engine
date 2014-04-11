<?php
class Template extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
 
    public function tableName()
    {
        return '{{template}}';
    }
    
    public function relations()
    {
        return array(
            'extension' => array(self::BELONGS_TO,'Extension','extension')
        );
    }
}
?>