<?php
class ApplicationConfigBehavior extends CBehavior
{
    public function events()
    {
        return array_merge(
            parent::events(),
            array(
                'onBeginRequest' => 'onBeginRequest'
            )
        );
    }
    
    public function onBeginRequest()
    {
        $app = Yii::app();

        // Setup application
        $app->headers->charset(Yii::app()->charset);
        $app->headers->mime(CHeaders::HEADER_TEXT_HTML);
        $app->urlManager->setUrlFormat(Yii::app()->settings->get('system','urlFormat'));
        
        if (ENGINE_APPTYPE == 'admin')
        {
            $app->setTheme($app->settings->get('admin','template'));
            $app->setLanguage($app->settings->get('admin','language'));
        }
        else if (ENGINE_APPTYPE == 'base')
        {
            $app->setTheme(Yii::app()->settings->get('website','template'));
            $app->setLanguage(Yii::app()->settings->get('website','language'));
        }
        

    }
}
?>