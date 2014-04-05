<?php
/**
 * YOnote ENGINE application
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://
 * @copyright 2014
 * @license http://
 */

/**
 * Access control constant, used for unauthorized access prevention
 */
define('YONOTE_ENGINE',true);
/**
 * Application type constant, used for application parts division
 */
define('ENGINE_APPTYPE','base');
/**
 * Enable Yii debug mode (should be removed in production)
 */
define('YII_DEBUG',true);

// Load Yii framework
require_once('framework/yii.php');
// Load configuration
require_once('engine/settings/config.php');
// Create new application instance
Yii::createWebApplication(SETTINGS_PATH.'/application.php');
// Run application
Yii::app()->run();
?>