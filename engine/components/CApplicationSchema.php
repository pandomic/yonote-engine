<?php
/**
 * CApplicationSchema class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/licence.html
 */

/**
 * CApplicationSchema allows database schema building from file.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class CApplicationSchema extends CApplicationComponent
{
    private $_schema = array();
    
    /**
     * @var string database component id.
     */
    public $dbComponentId = 'db';
    
    /**
     * Load database shema file.
     * @param string $schemaFile path to the schema file.
     * @return CApplicationSchema instance itself.
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
     * Build database schema.
     * @return CApplicationSchema instance itself.
     */
    public function build()
    {
        if (count($this->_schema) > 0)
            foreach ($this->_schema as $queryString)
            {
                $queryString = trim($queryString);
                if ($queryString != null)
                {
                    $db = Yii::app()->getComponent($this->dbComponentId);
                    $db->createCommand($queryString)->execute();
                }
            }
        return $this;
    }
}
?>