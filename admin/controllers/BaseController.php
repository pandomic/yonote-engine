<?php
/**
 * BaseController class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

/**
 * Administrative panel main controller.
 * Responds for the admin panel main page, as user login and logout.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class BaseController extends CApplicationController
{
    /**
     * Controller filters.
     * @return array filters.
     */
    public function filters()
    {
        return array(
            'accessControl'
        );
    }
    
    /**
     * Controller access rules.
     * @return array access rules.
     */
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array('index'),
                'roles' => array('admin.index')
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
    
    /**
     * Login action.
     * @return void.
     */
    public function actionLogin()
    {
        if (Yii::app()->user->checkAccess('admin.index'))
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
    
    /**
     * Logout action.
     * @return void.
     */
    public function actionLogout()
    {
        $app = Yii::app();
        $app->user->logout();
        $this->redirect($app->user->returnUrl);
    }
    
    /**
     * Admin panel index page.
     * @return void.
     */
    public function actionIndex()
    {
        $this->render('index');
    }
}
?>