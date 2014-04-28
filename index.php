<?php
/**
 * YOnote ENGINE frontend application file
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/licence.html
 */

/**
 * Access control constant, used for unauthorized access prevention
 */
define('YONOTE_ENGINE',true);
/**
 * Application type constant, used for application parts division
 */
define('ENGINE_APPTYPE','base');

// Load configuration
require_once('engine/settings/config.php');
// Load Yii framework
require_once('framework/yii.php');

// Create new application instance
Yii::createWebApplication(SETTINGS_PATH.'/application.php');
// Run application
Yii::app()->run();
?>