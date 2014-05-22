<?php
class BaseController extends CApplicationController
{
    private static $_baseContent = null;
    
    public function actionIndex()
    {
        $this->render('index',array(
            'content' => self::$_baseContent
        ));
    }
    
    public function actionError()
    {
        if($error = Yii::app()->errorHandler->error)
            $this->renderPartial('error',array('error' => $error));
    }
    
    public static function setBaseContent($content)
    {
        self::$_baseContent = $content;
    }
}
?>