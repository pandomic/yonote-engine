<?php
class SettingsController extends CApplicationController
{
    public function actionIndex()
    {
        $this->pageTitle = Yii::t('settings','page.settings.title');
        $this->addBreadcrumb(
            Yii::t('settings','page.settings.title'),
            Yii::app()->createUrl($this->getRoute())
        );
        $model = new SystemSettings();
        if (isset($_POST['SystemSettings'])){
            $model->setAttributes($_POST['SystemSettings']);
            if ($model->save())
            {
                Yii::app()->user->setFlash('settingsSuccess',Yii::t('settings','success.settings.update'));
                $this->refresh();
            }
        }
        $this->render('index',array(
            'model' => $model
        ));
    }
}
?>