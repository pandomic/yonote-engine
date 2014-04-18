<?php
class ExtensionsController extends CApplicationController
{
    private $_model = null;
    
    public function actionIndex()
    {
        
        $this->pageTitle = Yii::t('extensions','Extensions manager');
        
        $this->addBreadcrumb(
                'Расширения',
                Yii::app()->createUrl($this->route)
        );
        
        $extensions = Extension::model()
            ->with('modules','widgets')
            ->findAll();
        
        $modules = array();
        $widgets = array();
        $templates = array();
        
        foreach ($extensions as $extension)
        {
            $modules = array_merge($modules,$extension->modules);
            $templates = array_merge($templates,$extension->templates);
            
            foreach ($extension->widgets as $widget)
                if ((int) $widget->type == 0)
                    $widgets[] = $widget;
        }

        $this->render('index',array(
            'extensions' => $extensions,
            'modules' => $modules,
            'widgets' => $widgets,
            'templates' => $templates
        ));
    }
    
    public function actionInfo($e)
    {
        $model = $this->loadModel()->findByPk($e);
        
        if (isset($_GET['ajax']) && $_GET['ajax'] == 'info-requred')
            $this->renderPartial('_info',array(
                'model' => $model,
                'data' => unserialize($model->data)
            ));
        else
        {
            if ($model === null)
                throw new CHttpException(404,'Object not found');
            $this->render('info',array(
                'model' => $model,
                'data' => unserialize($model->data)
            ));
        }
    }
    
    public function actionModstate()
    {
        if(Yii::app()->request->isPostRequest && isset($_POST['action']))
        {
            $updated = 0;
            $status = false;
            
            $criteria = new CDbCriteria();
            $criteria->addInCondition('name',$_POST['select']);
            if ($_POST['action'] == 'enable')
                $status = true;
            $updated = Module::model()->updateAll(array(
                'installed' => $status,
                'updatetime' => time()
            ),$criteria);
            if (count($updated) == 0)
                Yii::app()->user->setFlash('extensionsWarning','Nothing happends');
            else
                Yii::app()->user->setFlash('extensionsSuccess','Completed');
            $this->redirect(array('index'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    public function actionDelete()
    {
        if(Yii::app()->request->isPostRequest)
        {
            $model = $this->loadModel();
            
            if ($model->removeExtensions($_POST['select']) == 0)
                Yii::app()->user->setFlash('extensionsWarning',Yii::t('extensions','Nothing has been removed!'));
            else
                Yii::app()->user->setFlash('extensionsSuccess',Yii::t('extensions','Selected extensions have been successfully removed.'));
            $this->redirect(array('index'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
    
    public function actionUpload()
    {
        $model = new Extension('upload');
        
        if (isset($_POST['Extension']))
        {
            $model->attributes = $_POST['Extension'];
            
            if (isset($_POST['ajax']) && $_POST['ajax'] == 'extension-upload')
            {
                if ($model->validate() && $model->loadExtension())
                    Yii::app()->user->setFlash('extensionsSuccess',Yii::t('extensions','The extension has been installed.'));
                else
                    Yii::app()->user->setFlash('extensionsWarning',Yii::t('extensions','Some error occurred while installing this extension.'));
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
            
            if ($model->validate() && $model->loadExtension()){
                Yii::app()->user->setFlash('extensionsSuccess',Yii::t('extensions','The extension has been installed.'));
                $this->redirect($this->createUrl('extensions/index'));
            }
            else
                Yii::app()->user->setFlash('extensionsWarning',Yii::t('extensions','Some error occurred while installing this extension.'));

        }

        if (isset($_GET['ajax']) && $_GET['ajax'] == 'upload-required')
            $this->renderPartial('_upload',array('model' => $model));
        else
            $this->render('upload',array('model' => $model));
    }

    public function loadModel()
    {
        if($this->_model === null)
            $this->_model = Extension::model();
        return $this->_model;
    }
}
?>