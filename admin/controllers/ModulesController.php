<?php
/**
 * ModulesController class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

/**
 * Modules management controller, used in administrative panel.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class ModulesController extends CApplicationController
{
    
    private $_modulesListModel = null;
    private $_moduleEditModel = null;
    
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
                'roles' => array('admin.modules.index')
            ),
            array(
                'allow',
                'actions' => array('up'),
                'roles' => array('admin.modules.up')
            ),
            array(
                'allow',
                'actions' => array('down'),
                'roles' => array('admin.modules.down')
            ),
            array(
                'allow',
                'actions' => array('status'),
                'roles' => array('admin.modules.status')
            ),
            array(
                'allow',
                'actions' => array('info'),
                'roles' => array('admin.modules.info')
            ),
            array(
                'allow',
                'actions' => array('add'),
                'roles' => array('admin.modules.add')
            ),
            array(
                'allow',
                'actions' => array('remove'),
                'roles' => array('admin.modules.remove')
            ),
            array(
                'deny',
                'users' => array('*')
            )
        );
    }
    
    /**
     * Move module up.
     * @return void.
     */
    public function actionUp($id)
    {
        $record = $this->loadModuleEditModel($id);
        $aboveRecords = Module::model()->findAll('position > :position',array(
            ':position' => $record->position
        ));
        if (count($aboveRecords) > 0)
        {
            $minRecord = $aboveRecords[0];
            foreach ($aboveRecords as $r)
                if ($r->position < $minRecord->position)
                    $minRecord = $r;
            $currentPosition = $record->position;
            $record->position = $minRecord->position;
            $minRecord->position = $currentPosition;
            $record->save();
            $minRecord->save();
        }
        else
            Yii::app()->user->setFlash('modulesWarning',Yii::t('modules','warning.move.up'));
        $this->redirect(array('index'));
    }
    
    /**
     * Move module down.
     * @return void.
     */
    public function actionDown($id)
    {
        $record = $this->loadModuleEditModel($id);
        $belowRecords = Module::model()->findAll('position < :position',array(
            ':position' => $record->position
        ));
        if (count($belowRecords) > 0)
        {
            $maxRecord = $belowRecords[0];
            foreach ($belowRecords as $r)
                if ($r->position > $maxRecord->position)
                    $maxRecord = $r;
            $currentPosition = $record->position;
            $record->position = $maxRecord->position;
            $maxRecord->position = $currentPosition;
            $record->save();
            $maxRecord->save();
        }
        else
            Yii::app()->user->setFlash('modulesWarning',Yii::t('modules','warning.move.down'));
        $this->redirect(array('index'));
    }
    
    /**
     * Togle module status (enabled|disabled).
     * @return void.
     */
    public function actionStatus($id)
    {
        $record = $this->loadModuleEditModel($id);
        if ((boolean) $record->installed)
            $record->installed = false;
        else
            $record->installed = true;
        $record->save();
        Yii::app()->user->setFlash('modulesSuccess',Yii::t('modules','success.status.update'));
        $this->redirect(array('index'));
    }
    
    /**
     * Show module info.
     * @return void.
     */
    public function actionInfo($id)
    {
        $this->pageTitle = Yii::t('modules','page.info.title');
        $this->setPathsQueue(array(
            Yii::t('modules','page.modules.title') => Yii::app()->createUrl('modules/index'),
            Yii::t('modules','page.info.title') => Yii::app()->createUrl($this->getRoute())
        ));
        $this->render('info',array(
            'model' => $this->loadModuleEditModel($id)
        ));
    }
    
    /**
     * Select and upload new module.
     * @return void.
     */
    public function actionAdd()
    {
        $this->pageTitle = Yii::t('modules','page.add.title');
        $this->setPathsQueue(array(
            Yii::t('modules','page.modules.title') => Yii::app()->createUrl('modules/index'),
            Yii::t('modules','page.add.title') => Yii::app()->createUrl($this->getRoute())
        ));
        $model = new Module('add');
        if (isset($_POST['Module']))
        {
            $model->setAttributes($_POST['Module']);
            if ($model->save())
            {
                Yii::app()->user->setFlash('modulesSuccess',Yii::t('modules','success.module.add'));
                $this->redirect(array('index'));
            }
        }
        $this->render('add',array(
            'model' => $model
        ));
    }
    
    /**
     * Remove module.
     * @return void.
     */
    public function actionRemove($id)
    {
        $record = $this->loadModuleEditModel($id);
        $record->delete();
        Yii::app()->user->setFlash('modulesSuccess',Yii::t('modules','success.module.remove'));
        $this->redirect(array('index'));
    }
    
    /**
     * Show modules manager index.
     * @return void.
     */
    public function actionIndex()
    {
        $this->pageTitle = Yii::t('modules','page.modules.title');
        $this->setPathsQueue(array(
            Yii::t('modules','page.modules.title') => Yii::app()->createUrl($this->getRoute())
        ));
        $this->render('index',array(
            'models' => $this->loadModulesListModel()
        ));
    }
    
    /**
     * Load modules models with specified conditions.
     * @return array of models.
     */
    public function loadModulesListModel()
    {
        if ($this->_modulesListModel === null)
        {
            $criteria = new CDbCriteria();
            $criteria->order = 'position DESC';
            if (isset($_POST['search']))
                Yii::app()->session['modulesSearch'] = $_POST['search'];
            if (Yii::app()->session['modulesSearch'] !== null){
                $criteria->addSearchCondition('name',Yii::app()->session['modulesSearch'],true);
                $criteria->addSearchCondition('title',Yii::app()->session['modulesSearch'],true,'OR');
            }
            $this->_modulesListModel = Module::model()->findAll($criteria);
        }
        return $this->_modulesListModel;
    }
    
    /**
     * 
     * @return type
     * @throws CHttpException if module not found or invalid request given.
     */
    public function loadModuleEditModel($id)
    {
        if ($this->_moduleEditModel === null)
        {
            $this->_moduleEditModel = Module::model()->findByPk($id);
            if ($this->_moduleEditModel === null)
                throw new CHttpException(404,Yii::t('system','error.404.description'));
        }
        return $this->_moduleEditModel;
    }
}
?>