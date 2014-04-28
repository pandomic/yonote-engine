<?php
class AuthItemChild extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
 
    public function tableName()
    {
        return '{{auth_item_child}}';
    }
    
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