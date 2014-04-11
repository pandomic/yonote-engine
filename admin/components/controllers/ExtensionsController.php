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
        
        if (isset($_REQUEST['ajax']) && $_POST['ajax'] == 'info-requred')
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
            
            if ($model === null || !is_array($_POST['select']))
                throw new CHttpException(404,'The request url not found');
            
            $model->deleteAll('name IN(:select)',array(
                ':select' => implode(',',$_POST['select'])
            ));
            
            $this->redirect(array('index'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    public function loadModel()
    {
        if($this->_model === null)
            $this->_model = Extension::model();
        
        return $this->_model;
    }
}
?>