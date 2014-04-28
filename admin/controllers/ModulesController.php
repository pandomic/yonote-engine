<?php
class ModulesController extends CApplicationController
{
    
    private $_modulesListModel = null;
    private $_moduleEditModel = null;
    
    public function actionUp()
    {
        $record = $this->loadModuleEditModel();
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
    
    public function actionDown()
    {
        $record = $this->loadModuleEditModel();
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
    
    public function actionStatus()
    {
        $record = $this->loadModuleEditModel();
        if ((boolean) $record->installed)
            $record->installed = false;
        else
            $record->installed = true;
        $record->save();
        Yii::app()->user->setFlash('modulesSuccess',Yii::t('modules','success.status.update'));
        $this->redirect(array('index'));
    }
    
    public function actionInfo()
    {
        $this->pageTitle = Yii::t('modules','page.info.title');
        $this->addBreadcrumb(
            Yii::t('modules','page.modules.title'),
            Yii::app()->createUrl('modules/index')
        )->addBreadcrumb(
            Yii::t('modules','page.info.title'),
            Yii::app()->createUrl($this->getRoute())
        );
        $this->render('info',array(
            'model' => $this->loadModuleEditModel()
        ));
    }
    
    public function actionAdd()
    {
        $this->pageTitle = Yii::t('modules','page.add.title');
        $this->addBreadcrumb(
            Yii::t('modules','page.modules.title'),
            Yii::app()->createUrl('modules/index')
        )->addBreadcrumb(
            Yii::t('modules','page.add.title'),
            Yii::app()->createUrl($this->getRoute())
        );
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
    
    public function actionRemove()
    {
        $record = $this->loadModuleEditModel();
        $record->delete();
        Yii::app()->user->setFlash('modulesSuccess',Yii::t('modules','success.module.remove'));
        $this->redirect(array('index'));
    }
    
    public function actionIndex()
    {
        $this->pageTitle = Yii::t('modules','page.modules.title');
        $this->addBreadcrumb(
            Yii::t('modules','page.modules.title'),
            Yii::app()->createUrl($this->getRoute())
        );
        $this->render('index',array(
            'models' => $this->loadModulesListModel()
        ));
    }
    
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
    
    public function loadModuleEditModel()
    {
        if ($this->_moduleEditModel === null)
        {
            if (isset($_GET['id']))
            {
                $this->_moduleEditModel = Module::model()->findByPk($_GET['id']);
                if ($this->_moduleEditModel === null)
                    throw new CHttpException(404,Yii::t('system','error.404.description'));
            }
            else
                throw new CHttpException(400,Yii::t('system','error.400.description'));
        }
        return $this->_moduleEditModel;
    }
    
    public function updatePositions()
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'MIN(position) as min';
        $minRecord = Module::model()->find($criteria);
        if ($minRecord->min > 0)
        {
            $records = Module::model()->findAll('position >= :position',array(
                ':position' => $minRecord->min
            ));
            foreach ($records as $record)
            {
                $record->position -= (int) $minRecord->min;
                $record->save();
            }
        }
    }
}
?>