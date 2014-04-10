<?php
class CApplicationController extends CController
{
    /**
     * Rendered breadcrumbs
     * @var string 
     */
    public $breadcrumbs;
    
    private $_breadcrumbs = array();


    /**
     * Get widget
     * @param string $name widget name
     * @param boolean $captureOutput whether to capture the output of the widgets
     * @return CApplicationWidgets widgets manager object
     */
    public function widgetPos($name,$captureOutput=false)
    {
        return Yii::app()->wmanager->widget($name,$captureOutput);
    }
    
    /**
     * Add item to breadcrumbs
     * @param string $title item title
     * @param string $url item URL
     * @return self-object
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
     * Setup breadcrumbs before rendrering
     * @param string $view view to render
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