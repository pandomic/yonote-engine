<?php
/**
 * CApplicationController class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/licence.html
 */

/**
 * CApplicationController is the base YOnote ENGINE controller class
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class CApplicationController extends CController
{
    private $_breadcrumbs = array();
    
    /**
     * @var string rendered breadcrumbs.
     */
    public $breadcrumbs;
    
    /**
     * Add item to breadcrumbs.
     * @param string $title item title.
     * @param string $url item URL.
     * @return CApplicationController instance itself.
     */
    public function addBreadcrumb($title,$url)
    {
        $this->_breadcrumbs[] = array(
            'title' => $title,
            'url' => $url
        );
        return $this;
    }
    
    /**
     * Setup breadcrumbs before rendrering.
     * @param string $view view to render.
     * @return boolean beforeRender flag.
     */
    protected function beforeRender($view)
    {
        $this->breadcrumbs = $this->widget('BreadcrumbsWidget',array(
            'params' => array(
                'route' => $this->getRoute(),
                'links' => $this->_breadcrumbs
            )
        ),true);
        return parent::beforeRender($view);
    }
}
?>