<?php
class Module extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
 
    public function tableName()
    {
        return '{{module}}';
    }
    
    public function relations()
    {
        return array(
            'extension' => array(self::BELONGS_TO,'Extension','extension')
        );
    }
    
    public function primaryKey() 
    {
        return 'name';
    }
}
?>