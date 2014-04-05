<?php
/**
 * YOnote ENGINE application
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://
 * @copyright 2014
 * @license http://
 */

// Define access constant
defined('YONOTE_ENGINE') or define('YONOTE_ENGINE',true);
// Define current path constant
defined('THIS_PATH') or define('THIS_PATH',dirname(__FILE__));

defined('YII_DEBUG') or define('YII_DEBUG',true);

define('ENGINE_APPTYPE','admin');

// Load Yii framework
require_once('../framework/yii.php');
// Load configuration
require_once('../engine/settings/config.php');

// Create new application instance
Yii::createWebApplication(SETTINGS_PATH.'/application.php');

/*$auth=Yii::app()->authManager;

$auth->createOperation('admminAccess','Administrative access');

$role = $auth->createRole('administrator','Administrator',$bizRule);
$role->addChild('admminAccess');

$bizRule = 'return Yii::app()->user->getIsGuest();';
$auth->createRole('guest','Guest',$bizRule);

$bizRule = 'return !Yii::app()->user->getIsGuest();';
$role = $auth->createRole('authenticated','Authenticated',$bizRule);
$role->addChild('administrator');

$auth->assign('administrator','admin');*/
 
// Run application
Yii::app()->run();
?>