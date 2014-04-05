<?php
class CApplicationPids extends CApplicationComponent
{
    /**
     * @var string database component id
     */
    public $dbComponentId = 'db';
    /**
     * @var modules table name
     */
    public $tableName = '{{pids}}';
    /**
     * @var string cache component id
     */
    public $cacheComponentId = 'cache';
    /**
     * @var int cache time
     */
    public $cacheTime = 1000;
    
    private $_pids = array();
    private $_currentPid = -1;
    private $_currentRoute;
    private $_controlFlag = false;

    public function init()
    {
        $db = Yii::app()->getComponent($this->dbComponentId);
        
        $dependency = new CDbCacheDependency("
            SELECT MAX(time) FROM {$this->tableName}
        ");
        
        $results = $db->cache($this->cacheTime,$dependency)
            ->createCommand()
            ->setFetchMode(PDO::FETCH_OBJ)
            ->select('pageid,route')
            ->from($this->tableName)
            ->queryAll();

        foreach ($results as $record){
            $this->_pids[$record->route] = $record->pageid;
        }
        
        parent::init();
    }
    
    public function prepare($params)
    {
        $urlFormat = Yii::app()->urlManager->getUrlFormat();
        Yii::app()->urlManager->setUrlFormat('get');
        $this->_currentRoute = Yii::app()->createUrl(
            Yii::app()->controller->getRoute(),$params
        );
        Yii::app()->urlManager->setUrlFormat($urlFormat);
        if (isset($this->_pids[$this->_currentRoute]))
            $this->_currentPid = $this->_pids[$this->_currentRoute];
        
        return $this;
    }
    
    public function save()
    {
        $this->_controlFlag = TRUE;
        if (!isset($this->_pids[$this->_currentRoute]))
        {
            $db = Yii::app()->getComponent($this->dbComponentId);
            $db->createCommand()->insert($this->tableName,array(
                'route' => $this->_currentRoute
            ));
        }
        return $this;
    }
    
    public function control()
    {
        if (!$this->_controlFlag)
        {
            if (isset($this->_pids[$this->_currentRoute]))
            {
                $db = Yii::app()->getComponent($this->dbComponentId);
                $db->createCommand()->delete(
                    $this->tableName,
                    'pageid=:pageid AND route=:route',
                    array(
                        ':pageid' => $this->_currentPid,
                        ':route' => $this->_currentRoute
                    )
                );
            }
            throw new CHttpException(404,Yii::t('system','Page not found!'));
        }
    }
    
    public function get($route)
    {
        return $this->_pids[$route];
    }
}
?>