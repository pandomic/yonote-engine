<?php
class BreadcrumbsWidget extends CWidget
{
    public $params = array(
        'route',
        'links' => array()
    );
    
    public function run()
    {
        $this->render('breadcrumbs',$this->params);
    }
}
?>