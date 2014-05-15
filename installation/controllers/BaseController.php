<?php
class BaseController extends CController
{
    public function actionIndex()
    {
        $currentStep = (int) Yii::app()->session['step'];
        
        if (Yii::app()->session['insLang'] != null)
            Yii::app()->setLanguage(Yii::app()->session['insLang']);
        
        switch ($currentStep)
        {
            case 3:
                Yii::app()->session->remove('step');
                $this->render('congratulations');
            break;
            case 2:

                $model = new SecondStep();
                if (isset($_POST['SecondStep']))
                {
                    $model->setAttributes($_POST['SecondStep']);
                    if ($model->validate())
                    {
                        Yii::app()->session['step'] = 3;
                        $this->refresh();
                    }
                }
                else
                    $model->validate();
                $this->render('requirements',array(
                    'template' => Yii::app()->request->baseUrl,
                    'model' => $model
                ));
            break;
            default:
                $model = new FirstStep();
                if (isset($_POST['FirstStep']))
                {
                    $model->setAttributes($_POST['FirstStep']);
                    if ($model->validate())
                    {
                        Yii::app()->session['step'] = 2;
                        Yii::app()->session['insLang'] = $model->insLang;
                        $this->refresh();
                    }
                }
                $this->render('index',array(
                    'model' => $model
                ));
            break;
        }
        
    }
    
    public function actionRequirements()
    {
        $model = new Requirements();
        $this->render('index',array(
            'template' => Yii::app()->request->baseUrl,
            'model' => $model
        ));
    }
    
    public function langsList()
    {
        $langs = scandir(realpath(__DIR__.'/../../engine/messages'));
        array_shift($langs);
        array_shift($langs);
        return $langs;
    }
}
?>