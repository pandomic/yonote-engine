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
        if(filter_input(INPUT_POST,'ajax')=='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        // collect user input data
        if(filter_has_var(INPUT_POST,'login'))
        {
            $model->attributes = filter_get(INPUT_POST,'login');
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
        Yii::app()->clientScript->registerCssFile(
            Yii::app()->assetManager->publish(
                Yii::getPathOfAlias('application.vendors.bootstrap').'/bootstrap.css'
            )
        );
        $this->render('test');
    }
}
?>