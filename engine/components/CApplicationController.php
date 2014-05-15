<?php
/**
 * CApplicationController class file.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/licence.html
 */

/**
 * CApplicationController is the base YOnote ENGINE controller class.
 * This controller extends the base Yii CController class with
 * breadcrumbs and additive assets functionality.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @since 1.0
 */
class CApplicationController extends CController
{
    /**
     * @var string rendered breadcrumbs.
     */
    public $pathsQueue = array();
    /**
     * @var string current template path
     */
    public $template;
    
    private $_template;
    
    /**
     * Init current template.
     * Form base template path.
     * @return void.
     */
    public function init()
    {
        if (ENGINE_APPTYPE == 'admin')
            $part = '';
        else if (ENGINE_APPTYPE == 'base')
            $part = '/engine';
        $this->_template = Yii::app()->getTheme()->getName();
        $this->template = Yii::app()->request->getBaseUrl().$part."/templates/".$this->_template;
        Yii::app()->language = Yii::app()->urlManager->getUrlLanguage();
    }
    
    /**
     * Publish an asset.
     * @param string $path asset path (e.g. application.vendors.bootstrap)
     * @return string path to asset.
     */
    public function asset($path)
    {
        return Yii::app()->assetManager->publish(
            Yii::getPathOfAlias($path),false,-1,YII_DEBUG
        );
    }
    
    /**
     * Publish asset from current template (e.g. assets folder in current
     * template folder, containing all css,js and other data, that can be
     * then accessed from the view file like
     * <?php $this->templateAsset('assets'); ?>"/js/example.js").
     * @param string $path asset path relative to the current template.
     * @return string path to asset.
     */
    public function templateAsset($path)
    {
        if (ENGINE_APPTYPE == 'admin')
            $scope = 'admin';
        else if (ENGINE_APPTYPE == 'base')
            $scope = 'application';
        return $this->asset("{$scope}.templates.{$this->_template}.{$path}");
    }
    
    public function setPathsQueue($paths)
    {
        $this->pathsQueue = $paths;
    }
}
?>