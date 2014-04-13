<?php
class ExtensionsController extends CApplicationController
{
    private $_model=null;
    
    public function actionIndex()
    {
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
    
    public function actionDelete()
    {
        if(Yii::app()->request->isPostRequest)
        {
            $model = $this->loadModel();
            
            if ($model->deleteByPk($_POST['select']) == 0)
                Yii::app()->user->setFlash('warning',Yii::t('extensions','Nothing has been removed!'));
            else
                Yii::app()->user->setFlash('success',Yii::t('extensions','Selected extensions have been successfully removed.'));
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
                    Yii::app()->user->setFlash('success',Yii::t('extensions','The extension has been installed.'));
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
            
            if ($model->validate() && $model->loadExtension()){
                Yii::app()->user->setFlash('success',Yii::t('extensions','The extension has been installed.'));
                $this->redirect($this->createUrl('extensions/index'));
            }
                

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