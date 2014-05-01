<?php
class BaseController extends CController
{
    public function actionIndex()
    {
        $this->render('index',array(
            'languages' => $this->langsList()
        ));
    }
    
    public function actionRequirements()
    {
        $model = new Requirements();
        $this->render('index',array(
            'template' => Yii::app()->request->baseUrl,
            'model' => $model
        ));
    }
    
    public function langsList()
    {
        $langs = scandir(Yii::getPathOfAlias('application.messages'));
        array_shift($langs);
        array_shift($langs);
        return $langs;
    }
}
?>