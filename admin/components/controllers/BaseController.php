<?php
class BaseController extends CApplicationController
{
    public function filters()
    {
        return array(
            'accessControl'
        );
    }

    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array('index'),
                'roles' => array('adminAccess')
            ),
            array(
                'allow',
                'actions' => array('login','logout'),
                'users' => array('*')
            ),
            array(
                'deny',
                'users' => array('*')
            )
        );
    }

    public function actionLogin()
    {
        if (Yii::app()->user->checkAccess('adminAccess'))
            $this->redirect(Yii::app()->user->getReturnUrl());
        
        $model = new LoginForm('login');
        if(isset($_POST['ajax']) && $_POST['ajax'] == 'login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        // collect user input data
        if(isset($_POST['login']))
        {
            $model->attributes = $_POST['login'];
            if($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->renderPartial('login',array('model' => $model));
    }
    
    public function actionLogout()
    {
        $app = Yii::app();
        if ($app->user->checkAccess('adminAccess'))
        {
            $app->user->logout();
            $this->redirect($app->user->returnUrl);
        }
        else
            $this->redirect($app->user->returnUrl);
    }

    public function actionIndex()
    {
        $this->render('test');
    }
}
?>