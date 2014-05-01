<?php
require_once('../framework/yii.php');
// Create new application instance
Yii::createWebApplication(array(
    'name' => 'YOnote ENGINE',
    'charset' => 'utf-8',
    'basePath' => __DIR__,
    'defaultController' => 'base',
    'import' => array('application.models.*')
));
// Run application
Yii::app()->run();
?>