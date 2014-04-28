<?php
/**
 * AuthAssignment class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

/**
 * AuthAssignment model class is used to manage authorization
 * data assignments.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class AuthAssignment extends CActiveRecord
{
    /**
     * Return static model of AuthAssignment.
     * @param string $className current class name.
     * @return AuthAssignment object.
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
        return '{{auth_assignment}}';
    }
}
?>