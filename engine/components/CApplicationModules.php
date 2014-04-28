<?php
/**
 * CApplicationModules class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/licence.html
 */

/**
 * CApplicationModules component was designed for automaticly modules loading.
 * 
 * This component should be preloaded to load all registered modules id
 * database.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class CApplicationModules extends CApplicationComponent
{
    private $_modules = array();
    
    /**
     * @var string modules path.
     */
    public $modulesPath = 'engine/modules';
    /**
     * @var string database component id.
     */
    public $dbComponentId = 'db';
    /**
     * @var modules table name.
     */
    public $tableName = '{{modules}}';
    /**
     * @var string cache component id.
     */
    public $cacheComponentId = 'cache';
    /**
     * @var int cache time.
     */
    public $cacheTime = 1000;
    
    /**
     * Load modules.
     * @return void.
     */
    public function init(){
        
        $db = Yii::app()->getComponent($this->dbComponentId);
        
        $dependency = new CDbCacheDependency("
            SELECT MAX(updatetime) FROM {$this->tableName}
        ");
        
        $results = $db->cache($this->cacheTime,$dependency)
            ->createCommand()
            ->setFetchMode(PDO::FETCH_OBJ)
            ->select('name,installed')
            ->from($this->tableName)
            ->order('position DESC')
            ->queryAll();
        
        foreach ($results as $record){
            if (file_exists("$this->modulesPath/{$record->name}"))
                if ((bool) $record->installed)
                    $this->_modules[] = $record->name;
        }

        Yii::app()->setModules($this->_modules);
        parent::init();
    }
    
    /**
     * Set modules path.
     * @param string $path modules path.
     * @return CApplicationModules instance itself.
     */
    public function setModulesPath($path){
        $this->modulesPath = $path;
        return $this;
    }
    
    /**
     * Set database component identifier.
     * @param string $component component identifier.
     * @return CApplicationModules instance itself.
     */
    public function setDbComponentId($component){
        $this->dbComponentId = $component;
        return $this;
    }
    
    /**
     * Get modules path.
     * @return string modules path.
     */
    public function getModulesPath(){
        return $this->modulesPath;
    }
    
    /**
     * Get database component identifier.
     * @return string database component identifier.
     */
    public function getDbComponentId(){
        return $this->dbComponentId;
    }
}
?>