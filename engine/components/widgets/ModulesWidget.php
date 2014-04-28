<?php
/**
 * ModulesWidget class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/licence.html
 */

/**
 * Returns modules list for different manipulations.
 * It can be used for modules list creation.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class ModulesWidget extends CWidget
{
    /**
     * Show widget.
     * @return void.
     */
    public function init()
    {
        $models = Module::model()->findAll('installed=1');
        $this->render('widget',array(
            'models' => $models
        ));
    }
}
?>