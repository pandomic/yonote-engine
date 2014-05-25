<?php
class FeedbackController extends CApplicationController
{
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
        );
    }

    public function actionIndex()
    {
        $model = new Feedback();
        if (isset($_POST['Feedback']))
        {
           $model->setAttributes($_POST['Feedback']);
           if ($model->validate() && $model->send())
           {
               
           }
           else
           {
               
           }
        }
        $this->render('index',array(
            'model' => $model
        ));
    }
}
?>