<?php
/**
 * ConfigBehavior class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/licence.html
 */

/**
 * Application configuration behavior.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class ConfigBehavior extends CBehavior
{
    /**
     * Return behavior events.
     * @return array events.
     */
    public function events()
    {
        return array_merge(
            parent::events(),
            array(
                'onBeginRequest' => 'onBeginRequest'
            )
        );
    }
    
    /**
     * Configure application
     * @return void
     */
    public function onBeginRequest()
    {
        $app = Yii::app();

        $app->headers->charset($app->charset);
        $app->headers->mime(CApplicationHeaders::HEADER_TEXT_HTML);
        $app->urlManager->setUrlFormat($app->settings->get('system','url.format'));
        $app->urlManager->setRedirectOnDefault($app->settings->get('system','url.redirectondefault',true));
        
        if (ENGINE_APPTYPE == 'admin')
        {
            Yii::setPathOfAlias('admin',ADMIN_PATH);
            $app->setTheme($app->settings->get('system','admin.template'));
            $app->setLanguage($app->settings->get('system','admin.language'));
            $app->setTimeZone($app->settings->get('system','admin.time.zone'));
            $app->urlManager->setDefaultLanguage($app->getLanguage());
        }
        else if (ENGINE_APPTYPE == 'base')
        {
            $app->setTheme(Yii::app()->settings->get('system','website.template'));
            $app->setLanguage(Yii::app()->settings->get('system','website.language'));
            $app->setTimeZone($app->settings->get('system','website.time.zone'));
            $app->urlManager->setDefaultLanguage($app->getLanguage());
        }
    }
}
?>