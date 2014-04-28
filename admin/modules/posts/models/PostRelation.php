<?php
class PostRelation extends CActiveRecord
{
    
    public $alias;
    public $content;

    public function tableName()
    {
        return '{{mod_post_relation}}';
    }
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

}
?>