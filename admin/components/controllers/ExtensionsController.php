<?php
class ExtensionsController extends CApplicationController
{
    public function actionIndex()
    {
        $this->addBreadcrumb(
                'Расширения',
                Yii::app()->createUrl($this->route)
        );
        $this->render('extensions');
    }
}
?>