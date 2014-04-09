<?php
class CApplicationSchema extends CApplicationComponent
{
    /**
     * @var string database component id
     */
    public $dbComponentId = 'db';
    
    private $_schema = array();
    
    /**
     * Load database shema file
     * @param string $schemaFile path to the schema file
     * @return object current object
     */
    public function load($schemaFile)
    {
        $this->_schema = array();
        if (file_exists($schemaFile)){
            $this->_schema = explode(';',file_get_contents($schemaFile));
        }
        return $this;
    }
    
    /**
     * Build database schema
     * @return object current object
     */
    public function build()
    {
        if (count($this->_schema) > 0)
            foreach ($this->_schema as $queryString)
            {
                $db = Yii::app()->getComponent($this->dbComponentId);
                $db->createCommand($queryString)->execute();
            }
        return $this;
    }
}
?>