<?php
define('YII_DEBUG',true);
require_once('../framework/yii.php');
// Create new application instance
Yii::createWebApplication(array(
    'name' => 'YOnote ENGINE',
    'charset' => 'utf-8',
    'basePath' => __DIR__,
    'defaultController' => 'base',
    'language' => 'en',
    'import' => array(
        'application.models.*',
        'application.components.*'
    ),
    'components' => array(
        'db' => array(
            'class' => 'CDbConnection'
        )
    )
));
// Run application
Yii::app()->run();
?>