<?php
class FeedbackController extends CApplicationController
{
    public function actions()
    {
        return array(
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
        );
    }

    public function actionIndex()
    {
        $this->pageTitle = Yii::t('FeedbackModule.feedback','page.feedback.title');
        $model = new Feedback();
        if (isset($_POST['Feedback']))
        {
           $model->setAttributes($_POST['Feedback']);
           $model->setMessageTemplate($this->renderPartial('mail',array(
               'model' => $model
           ),true));
           if ($model->save())
           {
               Yii::app()->user->setFlash('feedback.success',Yii::t('FeedbackModule.feedback','success.feedback'));
               $this->refresh();
           }
        }
        $this->render('index',array(
            'model' => $model
        ));
    }
}
?>