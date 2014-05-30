<?php
class PagesController extends CApplicationController
{
    
    
    public function actionIndex()
    {
        $models = Page::model()->findAll();
        $this->render('index',array(
            'models' => $models
        ));
    }
    
    public function actionShow($id)
    {
        $model = Page::model()->find(
            'alias=:alias AND (language=:language OR language=\'\')'
        ,array(
            ':alias' => $id,
            ':language' => Yii::app()->getLanguage()
        ));
        if ($model == null)
            throw new CHttpException(404,'Ohh nooo');
        $this->pageTitle = $model->title;
        $this->render('page',array(
            'model' => $model
        ));
    }
}
?>