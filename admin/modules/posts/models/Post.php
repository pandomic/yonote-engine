<?php
class Post extends CActiveRecord
{
    
    public $alias;
    public $title;
    public $short;
    public $full;
    public $thumbnail;
    public $language;
    public $removeThumbnail;
    
    private $_hashTags = array();
    private $_hashTagAlias = null;
    
    public function rules()
    {
        return array(
            array('short,full','filter','filter' => array($obj = new CHtmlPurifier(),'purify')),
            array(
                'alias,title,short,full','required',
                'message' => Yii::t('PostsModule.posts','model.post.error.required')
            ),
            array(
                'alias','unique',
                'message' => Yii::t('PostsModule.posts','model.post.error.alias.unique')
            ),
            array(
                'alias','match','pattern' => '/^(?:[a-z0-9_]+-?)+[a-z0-9_]$/i',
                'message' => Yii::t('PostsModule.posts','model.post.error.alias.match')
            ),
            array(
                'title','match','pattern' => '/^[\w\s.,\-!?:@]+$/iu',
                'message' => Yii::t('PostsModule.posts','model.post.error.title.match')
            ),
            array('language','languageRule'),
            array('removeThumbnail','boolean'),
            array(
                'alias','length',
                'min' => (int) Yii::app()->settings->get('posts','alias.length.min'),
                'max' => (int) Yii::app()->settings->get('posts','alias.length.max'),
                'tooShort' => Yii::t('PostsModule.posts','model.post.error.alias.short'),
                'tooLong' => Yii::t('PostsModule.posts','model.post.error.alias.long')
            ),
            array(
                'title','length',
                'min' => (int) Yii::app()->settings->get('posts','title.length.min'),
                'max' => (int) Yii::app()->settings->get('posts','title.length.max'),
                'tooShort' => Yii::t('PostsModule.posts','model.post.error.title.short'),
                'tooLong' => Yii::t('PostsModule.posts','model.post.error.title.long')
            ),
            array(
                'short','length',
                'min' => (int) Yii::app()->settings->get('posts','short.length.min'),
                'tooShort' => Yii::t('PostsModule.posts','model.post.error.short.short')
            ),
            array(
                'full','length',
                'min' => (int) Yii::app()->settings->get('posts','full.length.min'),
                'tooShort' => Yii::t('PostsModule.posts','model.post.error.full.short')
            ),
            array(
                'thumbnail','file','types' => 'jpg,jpeg,gif,png','allowEmpty' => true,
                'maxSize' => Yii::app()->settings->get('posts','thumbnail.size.max'),
                'tooLarge' => Yii::t('PostsModule.posts','model.post.error.thumbnail.size.large'),
                'tooMany' => Yii::t('PostsModule.posts','model.post.error.thumbnail.many'),
                'wrongType' => Yii::t('PostsModule.posts','model.post.error.thumbnail.type')
            )
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'alias' => Yii::t('PostsModule.posts','model.post.alias'),
            'title' => Yii::t('PostsModule.posts','model.post.title'),
            'full' => Yii::t('PostsModule.posts','model.post.content.full'),
            'short' => Yii::t('PostsModule.posts','model.post.content.short'),
            'language' => Yii::t('PostsModule.posts','model.post.language'),
            'thumbnail' => Yii::t('PostsModule.posts','model.post.thumbnail'),
            'removeThumbnail' => Yii::t('PostsModule.posts','model.post.removeThumbnail')
        );
    }
    
    public function behaviors()
    {
        return array(
            'LanguagesBehavior' => array(
                'class' => 'LanguagesBehavior'
            ),
            'ImageBehavior' => array(
                'class' => 'ImageBehavior',
                'fileField' => 'thumbnail',
                'savePath' => '{uploads}/images',
                'checkSides' => true,
                'minWidth' => (int) Yii::app()->settings->get('posts','thumbnail.width.min'),
                'minHeight' => (int) Yii::app()->settings->get('posts','thumbnail.height.min'),
                'maxWidth' => (int) Yii::app()->settings->get('posts','thumbnail.width.max'),
                'maxHeight' => (int) Yii::app()->settings->get('posts','thumbnail.height.max'),
                'resizeImage' => Yii::app()->settings->get('posts','thumbnail.resize.enabled',true),
                'cropOnResize' => true,
                'resizeWidth' => (int) Yii::app()->settings->get('posts','thumbnail.resize.width'),
                'resizeHeight' => (int) Yii::app()->settings->get('posts','thumbnail.resize.height'),
                'quality' => (int) Yii::app()->settings->get('posts','thumbnail.quality')
            )
        );
    }
    
    public function beforeSave()
    {
        $this->_processHashTags($this->short);
        $this->_processHashTags($this->full);
        
        $this->updatetime = time();
        
        $oldThumbnail = str_replace(
            array_keys($this->placeholders),
            array_values($this->placeholders),
            self::model()->findByPk($this->alias)->thumbnail
        );

        $image = $this->processImage();
        if ($image === false && $this->getImageError() != ImageBehavior::ERROR_FILE_EMPTY){
            $status = $this->getImageError();

            $minWidth = Yii::app()->settings->get('posts','thumbnail.width.min');
            $maxWidth = Yii::app()->settings->get('posts','thumbnail.width.max');
            $minHeight = Yii::app()->settings->get('posts','thumbnail.height.min');
            $maxHeight = Yii::app()->settings->get('posts','thumbnail.height.max');

            if ($status == ImageBehavior::ERROR_SIDES_BIG)
                $this->addError('photo',Yii::t('PostsModule.posts','model.post.error.thumbnail.sides.large',array(
                    '{maxwidth}' => $maxWidth,'{maxheight}' => $maxHeight
                )));
            else if ($status == ImageBehavior::ERROR_SIDES_SMALL)
                $this->addError('photo',Yii::t('PostsModule.posts','model.post.error.thumbnail.sides.small',array(
                    '{minwidth}' => $minWidth,'{minheight}' => $minHeight
                )));
            return false;
        }
        else if ($image !== false)
        {
            if (file_exists($oldThumbnail))
                unlink($oldThumbnail);
            $this->thumbnail = $image;
        }
        
        if ($this->removeThumbnail)
        {
            $this->thumbnail = null;
            if (file_exists($oldThumbnail))
                unlink($oldThumbnail);
        }

        return parent::beforeSave();
    }
    
    public function tableName()
    {
        return '{{mod_post}}';
    }
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function relations()
    {
        return array(
            'relations' => array(self::HAS_MANY,'PostRelation','postid'),
            'tags' => array(self::HAS_MANY,'PostHashtag',array('hashtagid' => 'name'),'through' => 'relations')
        );
    }
    
    public function languageRule($attribute,$params)
    {
        if ($this->language != null)
        {
            if (!in_array($this->language,array_keys($this->getLanguages())))
                $this->addError($attribute,Yii::t('PostsModule.posts','model.post.error.language'));
        }
    }
    
    public function afterSave()
    {
        PostRelation::model()->deleteAll('postid=:postid',array(
            ':postid' => $this->alias
        ));
        foreach ($this->_hashTags as $tag)
        {
            $relation = new PostRelation();
            $relation->hashtagid = $tag;
            $relation->postid = $this->alias;
            $relation->save();
        }
        return parent::afterSave();
    }
    
    public function replaceHashTags()
    {
        $this->short = $this->_replaceHashTags($this->short);
        $this->full = $this->_replaceHashTags($this->full);
    }

    public function setHashtagAlias($url)
    {
        $this->_hashTagAlias = $url;
    }
    
    private function _replaceHashTags($source)
    {
        if(preg_match_all('/(#[a-z0-9]+)/i',$source,$matches))
        {
            $hashTags = array_unique($matches[1]);
            $replace = array();
            foreach ($hashTags as $tag)
            {
                $replace[] = str_replace('{tag}',$tag,$this->_hashTagAlias);
            }
            $source = str_replace($matches[1],$replace,$source);
        }
        return $source;
    }
    
    private function _processHashTags($source)
    {
        if ($source !== null)
        {
            if(preg_match_all('/(#([a-z0-9]+))/i',$source,$matches))
            {
                $hashTags = array_unique($matches[2]);
                $this->_hashTags = array_unique(array_merge($this->_hashTags,$hashTags));
                
                foreach ($hashTags as $tag)
                {
                    $status = PostHashtag::model()->exists('name=:name',array(
                        ':name' => $tag
                    ));
                    if (!$status)
                    {
                        $hashtag = new PostHashtag();
                        $hashtag->name = $tag;
                        $hashtag->save();
                    }
                }
            }
        }
    }
}
?>