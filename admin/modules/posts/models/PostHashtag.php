<?php
class PostHashtag extends CActiveRecord
{
    
    public $alias;
    public $content;

    public function tableName()
    {
        return '{{mod_post_hashtag}}';
    }
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function relations()
    {
        return array(
            'relations' => array(self::HAS_MANY,'PostRelation','hashtagid'),
            'posts' => array(self::HAS_MANY,'Post',array('postid' => 'alias'),'through' => 'relations')
        );
    }

}
?>