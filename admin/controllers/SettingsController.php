<?php
/**
 * SettingsController class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

/**
 * System settings controller, used in administrative panel.
 * Allow to show and update system settings.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class SettingsController extends CApplicationController
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
                'roles' => array('admin.settings.index')
            ),
            array(
                'deny',
                'users' => array('*')
            )
        );
    }
    
    /**
     * Show and update settings.
     * @return void.
     */
    public function actionIndex()
    {
        $this->pageTitle = Yii::t('settings','page.settings.title');
        $this->setPathsQueue(array(
            Yii::t('settings','page.settings.title') => Yii::app()->createUrl($this->getRoute())
        ));
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