<?php
class PostsSettings extends CFormModel
{
    public $adminPostsPageSize;
    public $aliasLengthMax;
    public $aliasLengthMin;
    public $fullLengthMin;
    public $shortLengthMin;
    public $thumbHeightMax;
    public $thumbHeightMin;
    public $thumbWidthMax;
    public $thumbWidthMin;
    public $thumbQuality;
    public $thumbResize;
    public $thumbResizeWidth;
    public $thumbResizeHeight;
    public $thumbSizeMax;
    public $titleLengthMax;
    public $titleLengthMin;
    
    private $_settings = array();
    private $_relations = array();

    public function rules()
    {
        return array(
            array('thumbResize','boolean'),
            array(
                'adminPostsPageSize,aliasLengthMax,aliasLengthMin,fullLengthMin,shortLengthMin,thumbHeightMax,thumbHeightMin,thumbWidthMax,thumbWidthMin,thumbQuality,thumbResize,thumbResizeWidth,thumbResizeHeight,thumbSizeMax,titleLengthMax,titleLengthMin',
                'required',
                'message' => Yii::t('PostsModule.settings','model.postssettings.error.required')
            ),
            array(
                'adminPostsPageSize,aliasLengthMax,aliasLengthMin,fullLengthMin,shortLengthMin,thumbHeightMax,thumbHeightMin,thumbWidthMax,thumbWidthMin,thumbResizeWidth,thumbResizeHeight,thumbSizeMax,titleLengthMax,titleLengthMin','numerical','integerOnly' => true,'min' => 1,
                'tooSmall' =>  Yii::t('PostsModule.settings','model.postssettings.error.small'),
                'message' => Yii::t('PostsModule.settings','model.postssettings.error.integer')
            ),
            array(
                'thumbQuality','numerical','integerOnly' => true,'min' => 1, 'max' => 100,
                'tooSmall' => Yii::t('PostsModule.settings','model.postssettings.error.small'),
                'tooBig' => Yii::t('PostsModule.settings','model.postssettings.error.big'),
                'message' => Yii::t('PostsModule.settings','model.postssettings.error.integer')
            )
        );
    }
    
    public function save()
    {
        if (!$this->validate())
            return false;
        foreach ($this->_relations as $k => $v)
        {
            $model = Setting::model()->find('name=:name AND category=:cat',array(
                ':name' => $k,
                ':cat' => 'posts'
            ));
            if ($model !== null)
            {
                $model->setAttribute('value',$this->{$v});
                $model->save();
            }
        }
        return true;
    }
    
    public function attributeLabels()
    {
        $labels = array();
        foreach ($this->_relations as $k => $v)
            $labels[$v] = Yii::t('PostsModule.settings',$this->_settings[$k]->description);
        return $labels;
    }

    public function init()
    {
        $this->_relations = array(
            'admin.posts.page.size' => 'adminPostsPageSize',
            'alias.length.max' => 'aliasLengthMax',
            'alias.length.min' => 'aliasLengthMin',
            'full.length.min' => 'fullLengthMin',
            'short.length.min' => 'shortLengthMin',
            'thumbnail.height.max' => 'thumbHeightMax',
            'thumbnail.height.min' => 'thumbHeightMin',
            'thumbnail.width.max' => 'thumbWidthMax',
            'thumbnail.width.min' => 'thumbWidthMin',
            'thumbnail.resize.enabled' => 'thumbResize',
            'thumbnail.resize.width' => 'thumbResizeWidth',
            'thumbnail.resize.height' => 'thumbResizeHeight',
            'thumbnail.size.max' => 'thumbSizeMax',
            'thumbnail.quality' => 'thumbQuality',
            'title.length.max' => 'titleLengthMax',
            'title.length.min' => 'titleLengthMin'
        );
        
        $criteria = new CDbCriteria();
        $criteria->params = array(':category' => 'posts');
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