<?php
/**
 * AuthItemChild class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

/**
 * This class is representation of auth items relations.
 * It is used by other models to build auth items relations.
 * It can be also used to build full auth items tree.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class AuthItemChild extends CActiveRecord
{
    /**
     * Return static model of AuthItemChild.
     * @param string $className current class name.
     * @return AuthItemChild object.
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
        return '{{auth_item_child}}';
    }
    
    /**
     * Build full auth items tree.
     * @return array auth items tree.
     */
    public function tree()
    {
        // Load relations
        $relations = self::model()->findAll();
        // Relations count (needed for full tree)
        $count = count($relations);
        // Results array
        $parents = array();
        // Additional iterations for full tree
        for ($i = 0; $i < $count; $i++)
        {
            // Build tree
            foreach ($relations as $relation)
            {
                // New item found, create array
                if (!is_array($parents[$relation->parent]))
                    $parents[$relation->parent] = array();
                // Item already exists, create new brunch
                if (isset($parents[$relation->child]))
                {
                    $parents[$relation->parent][$relation->child] = $parents[$relation->child];
                    $key = array_search($relation->child,$parents[$relation->parent]);
                    if ($key !== false)
                        unset($parents[$relation->parent][$key]);
                }
                // Add single item
                else if (!in_array($relation->child,$parents[$relation->parent]))
                    $parents[$relation->parent][] = $relation->child;
            }
        }
        return $parents;
    }
}
?>