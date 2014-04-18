<?php
class AuthItemChild extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
 
    public function tableName()
    {
        return '{{auth_item_child}}';
    }
}
?>