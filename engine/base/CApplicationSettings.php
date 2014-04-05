<?php
class CApplicationSettings extends CApplicationComponent
{
    
    public $dbComponentId = 'db';
    public $cacheComponentId = 'cache';
    public $cacheTime = 1000;
    public $tableName = '{{settings}}';
    
    private $_settings = array();

    public function init(){
                
        $db = Yii::app()->getComponent($this->dbComponentId);
        $dependency = new CDbCacheDependency("
            SELECT MAX(time) FROM {$this->tableName}
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
    
    public function set($category,$id,$value)
    {
        if (!is_array($this->_settings[$category]))
        {
            $this->_settings[$category] = array();
        }
        
        $this->_settings[$category][$id] = $value;
        
        return $this;
    }
    
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
    }

    public function setDbComponentId($component)
    {
        $this->dbComponentId = $component;
    }
    
    public function setCacheComponentId($component)
    {
        $this->cacheComponentId = $component;
    }
    
    public function setCacheTime($cacheTime)
    {
        $this->cacheTime = $cacheTime;
    }
    
    public function setTable($table)
    {
        $this->tableName = $table;
    }

    public function getDbComponentId()
    {
        return $this->dbComponentId;
    }
    
    public function getCacheComponentId()
    {
        return $this->cacheComponentId;
    }
    
    public function getCacheTime()
    {
        return $this->cacheTime;
    }
    
    public function getTable()
    {
        return $this->tableName;
    }
}
?>