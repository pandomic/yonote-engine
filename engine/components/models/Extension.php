<?php
class Extension extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
 
    public function tableName()
    {
        return '{{extension}}';
    }
    
    public function relations()
    {
        return array(
            'modules' => array(self::HAS_MANY,'Module','extension'),
            'widgets' => array(self::HAS_MANY,'Widget','extension'),
            'templates' => array(self::HAS_MANY,'Template','extension'),
        );
    }
}
?>