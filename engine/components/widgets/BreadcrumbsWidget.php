<?php
/**
 * BreadcrumbsWidget class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/licence.html
 */

/**
 * Breadcrumbs widget.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class BreadcrumbsWidget extends CWidget
{
    /**
     * @var array widget params. 
     */
    public $params = array(
        'route',
        'links' => array()
    );
    
    /**
     * Show widget.
     * @return void.
     */
    public function init()
    {
        $this->render('breadcrumbs',$this->params);
    }
}
?>