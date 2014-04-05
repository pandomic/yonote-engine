<?php
class CApplicationModules extends CApplicationComponent
{
    
    /**
     * @var string modules path 
     */
    public $modulesPath = 'engine/modules';
    /**
     * @var string database component id
     */
    public $dbComponentId = 'db';
    /**
     * @var modules table name
     */
    public $tableName = '{{modules}}';
    /**
     * @var string cache component id
     */
    public $cacheComponentId = 'cache';
    /**
     * @var int cache time
     */
    public $cacheTime = 1000;

    /**
     * @var array db-based modules list
     */
    private $_modules = array();
    
    /**
     * Load modules
     * @return CModules self-object
     */
    public function init(){
        
        $db = Yii::app()->getComponent($this->dbComponentId);
        
        $dependency = new CDbCacheDependency("
            SELECT COUNT(installed) FROM {$this->tableName}
        ");
        
        $results = $db->cache($this->cacheTime,$dependency)
            ->createCommand()
            ->setFetchMode(PDO::FETCH_OBJ)
            ->select('modname')
            ->from($this->tableName)
            ->order('priority DESC')
            ->queryAll();
        
        foreach ($results as $record){
            $this->_modules[] = $record->modname;
        }
        
        Yii::app()->setModules($this->_modules);
        
        parent::init();
    }
    
    public function setModulesPath($path){
        $this->modulesPath = $path;
        return $this;
    }
    
    public function setDbComponentId($component){
        $this->dbComponentId = $component;
    }

    public function getModulesPath(){
        return $this->modulesPath;
    }
    
    public function getDbComponentId(){
        return $this->dbComponentId;
    }
}
?>