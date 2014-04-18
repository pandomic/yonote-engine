<?php
class AuthItem extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
 
    public function tableName()
    {
        return '{{auth_item}}';
    }
    
    public function relations(){
        return array(
            'childrelations' => array(self::HAS_MANY,'AuthItemChild','parent'),
            'parentrelations' => array(self::HAS_MANY,'AuthItemChild','child'),
            'children' => array(self::HAS_MANY,'AuthItem',array('child' => 'name'),'through' => 'childrelations'),
            'parents' => array(self::HAS_MANY,'AuthItem',array('parent' => 'name'),'through' => 'parentrelations')
        );
    }
}
?>