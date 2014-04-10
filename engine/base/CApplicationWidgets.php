<?php
class CApplicationWidgets extends CApplicationComponent
{
    /**
     * @var string database component id
     */
    public $dbComponentId = 'db';
    /**
     * @var modules table name
     */
    public $tableName = '{{widget}}';
    /**
     * @var string cache component id
     */
    public $cacheComponentId = 'cache';
    /**
     * @var int cache time
     */
    public $cacheTime = 1000;
    
    private $_done = false;
    private $_widgetsTags = array();
    private $_widgets;
    private $_currentRoute;
    private $_widget = null;
    
    /**
     * Init application component
     */
    public function init()
    {        
        $db = Yii::app()->getComponent($this->dbComponentId);
        
        $dependency = new CDbCacheDependency("
            SELECT MAX(updateTime) FROM {$this->tableName}
        ");
        
        $this->_widgets = $db->cache($this->cacheTime,$dependency)
            ->createCommand()
            ->setFetchMode(PDO::FETCH_OBJ)
            ->select('*')
            ->from($this->tableName)
            ->order('position DESC')
            ->queryAll();
        
        $this->_currentRoute = Yii::app()->createUrl(
            Yii::app()->getController()->getRoute(),
            $_GET
        );
        
        if ($this->_widgets !== false)
            foreach ($this->_widgets as $widget)
            {
                if ((bool) $widget->usePidsFlag)
                {
                    $usePids = explode(',',$widget->usePids);
                    if (in_array($this->_currentRoute,$usePids))
                        $this->_widgetsTags[$widget->widgetname] = $widget;
                }
                else if ((bool) $widget->unusePidsFlag)
                {
                    $unusePids = explode(',',$widget->unusePids);
                    if (!in_array($this->_currentRoute,$unusePids))
                        $this->_widgetsTags[$widget->widgetName] = $widget;
                }
                else
                    $this->_widgetsTags[$widget->widgetName] = $widget;
            }
            
        parent::init();
    }
    
    public function widget($name,$captureOutput=false)
    {
        if (isset($this->_widgetsTags[$name]))
        {
            $this->_widget = Yii::app()->getController()->widget(
                $this->_widgetsTags[$name]->classPath,
                unserialize($this->_widgetsTags[$name]->params),
                $captureOutput
            );
        }
        
        return $this;
    }
    
    public function endWidget()
    {
        if ($this->_widget !== null)
        {
            $this->_widget->endWidget();
        }
        
        return $this;
    }
}
?>
