<?php
/**
 * CApplicationSettings class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/licence.html
 */

/**
 * CApplicationSettings component provides settings management interface.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class CApplicationSettings extends CApplicationComponent
{
    private $_settings = array();
    
    /**
     * @var string database component identifier. 
     */
    public $dbComponentId = 'db';
    /**
     * @var string cache component identifier.
     */
    public $cacheComponentId = 'cache';
    /**
     * @var int cache time.
     */
    public $cacheTime = 1000;
    /**
     *
     * @var string settings table name.
     */
    public $tableName = '{{settings}}';
    
    /**
     * Load settings.
     * @return void.
     */
    public function init(){
                
        $db = Yii::app()->getComponent($this->dbComponentId);
        $dependency = new CDbCacheDependency("
            SELECT MAX(updateTime) FROM {$this->tableName}
        ");

        $db->cache($this->cacheTime,$dependency);
            
        $results = $db->createCommand()
            ->setFetchMode(PDO::FETCH_OBJ)
            ->select('*')
            ->from($this->tableName)
            ->queryAll();

        foreach ($results as $record){
            $this->_settings[$record->category][$record->name] = $record->value;
        }
        
        parent::init();
    }
    
    /**
     * Get param value.
     * @param string $category category identifier.
     * @param string $id param identifier.
     * @param boolean $asBoolean return as boolean.
     * @return string param value.
     */
    public function get($category,$id = NULL,$asBoolean = FALSE)
    {
        if (array_key_exists($category,$this->_settings))
        {
            if ($id === NULL)
                return $this->_settings[$category];
            else
            {
                if (array_key_exists($id,$this->_settings[$category]))
                {
                    if ($asBoolean)
                        return (bool) $this->_settings[$category][$id] == true;
                    else
                        return $this->_settings[$category][$id];
                }
            }
        }
    }
    
    /**
     * Set current parameter value (in memory only).
     * @param string $category category identifier.
     * @param string $id param identifier.
     * @param string $value param value
     * @return CApplicationSettings instance itself.
     */
    public function set($category,$id,$value)
    {
        if (!is_array($this->_settings[$category]))
        {
            $this->_settings[$category] = array();
        }
        
        $this->_settings[$category][$id] = $value;
        
        return $this;
    }
    
    /**
     * Update specified param, which was set by {@link CApplicationSettings::set()} method.
     * @param string $category category identifier.
     * @param string $id param identifier.
     * @return CApplicationSettings instance itself.
     */
    public function update($category,$id)
    {
        $db = Yii::app()->getComponent($this->dbComponentId);
         
        $record = $db->createCommand()
            ->setFetchMode(PDO::FETCH_OBJ)
            ->select('COUNT(paramid) AS count')
            ->from($this->tableName)
            ->where('category=:category AND name=:name',array(
                ':category' => $category,
                ':name' => $id
            ))
            ->queryRow();
        
        if ((int) $record->count > 0){
            $db->createCommand()
                ->update($this->tableName,array(
                    'value' => $this->_settings[$category][$id]
                ),'category=:category AND name=:name',array(
                    ':category' => $category,
                    ':name' => $id
                ));
        } else {
            $db->createCommand()
                ->insert($this->tableName,array(
                    'category' => $category,
                    'name' => $id,
                    'value' => $this->_settings[$category][$id]
                ));
        }
        return $this;
    }
    
    /**
     * Set database component identifier.
     * @param string $component component identifier.
     * @return CApplicationSettings instance itself.
     */
    public function setDbComponentId($component)
    {
        $this->dbComponentId = $component;
        return $this;
    }
    
    /**
     * Set cache component identifier.
     * @param string $component component identifier.
     * @return CApplicationSettings instance itself.
     */
    public function setCacheComponentId($component)
    {
        $this->cacheComponentId = $component;
        return $this;
    }
    
    /**
     * Set cache time.
     * @param int $cacheTime cache time.
     * @return CApplicationSettings instance itself.
     */
    public function setCacheTime($cacheTime)
    {
        $this->cacheTime = $cacheTime;
        return $this;
    }
    
    /**
     * Set settings table name.
     * @param string $table table name.
     * @return CApplicationSettings instance itself.
     */
    public function setTable($table)
    {
        $this->tableName = $table;
        return $this;
    }
    
    /**
     * Get database component identifier.
     * @return string identifier.
     */
    public function getDbComponentId()
    {
        return $this->dbComponentId;
    }
    
    /**
     * Get cache component identifier.
     * @return string component identifier.
     */
    public function getCacheComponentId()
    {
        return $this->cacheComponentId;
    }
    
    /**
     * Get cache time value.
     * @return int cache time.
     */
    public function getCacheTime()
    {
        return $this->cacheTime;
    }
    
    /**
     * Get settings table name.
     * @return string table name.
     */
    public function getTable()
    {
        return $this->tableName;
    }
}
?>