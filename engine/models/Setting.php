<?php
/**
 * Setting class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

/**
 * Manage settings model.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class Setting extends CActiveRecord
{
    /**
     * Return static model of Setting.
     * @param string $className current class name.
     * @return Setting object.
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
 
    /**
     * Model database table name.
     * @return string table name.
     */
    public function tableName()
    {
        return '{{setting}}';
    }
    
    /**
     * Action, that will be executed before model will be saved.
     * Upload and process module archive.
     * @return boolean parent beforeSave() status.
     */
    public function beforeSave()
    {
        $this->updatetime = time();
        return parent::beforeSave();
    }
}
?>