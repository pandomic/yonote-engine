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
    private $_currentPid = -1;
    
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
            ->order('positionOrder DESC')
            ->queryAll();

        parent::init();
    }
    
    /**
     * Set current page id
     * @param int $pid page id
     * @return object itself
     */
    public function setCurrentPid($pid)
    {
        $this->_currentPid = $pid;
        return $this;
    }
    
    /**
     * Get widgets output
     * @return mixed output
     */
    public function getWidgets()
    {
        if ($this->_done)
            return $this->_widgetsTags;
        
        if ($this->_widgets !== false)
            foreach ($this->_widgets as $widget)
            {
                if ((bool) $widget->usePidsFlag)
                {
                    $usePids = explode(',',$widget->usePids);
                    if (in_array($this->_currentPid,$usePids))
                        $this->_widgetsTags[$widget->positionName] .= 
                        Yii::app()->controller->widget(
                            $widget->path, 
                            array_merge_recursive(
                                array('id' => $widget->widgetname),
                                unserialize($widget->params)
                            ),
                            true
                        );
                }
                else if ((bool) $widget->unusePidsFlag)
                {
                    $unusePids = explode(',',$widget->unusePids);
                    if (!in_array($this->_currentPid,$unusePids))
                        $this->_widgetsTags[$widget->positionName] .= 
                        Yii::app()->controller->widget(
                            $widget->path, 
                            array_merge_recursive(
                                array('id' => $widget->widgetname),
                                unserialize($widget->params)
                            ),
                            true
                        );
                }
                else
                    $this->_widgetsTags[$widget->positionName] .= 
                        Yii::app()->controller->widget(
                            $widget->path, 
                            array_merge_recursive(
                                array('id' => $widget->widgetname),
                                unserialize($widget->params)
                            ),
                            true
                        );
            }
        
        $this->_done = true;
        return $this->_widgetsTags;
    }
}
?>