<?php
class BaseController extends CApplicationController
{
    public function actionIndex()
    {
        $this->render('index');
    }
}
?>