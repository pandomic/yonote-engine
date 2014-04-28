<?php
class BaseController extends CApplicationController
{
    
    public $param = 'value';
    public $layout = 'yo';

    public function actionIndex($act = 'xx')
    {
        $this->layout = '/layouts/test';
        $this->renderPartial('test');
    }
 
    public function actionContact()
    {
        // ...
    }
}
?>