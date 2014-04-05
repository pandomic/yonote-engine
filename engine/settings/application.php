<?php
/**
 * Yii framework configuration file
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://
 * @copyright 2014
 * @license http://
 */

// Check access level
defined('YONOTE_ENGINE') or die('Hacking attempt!');

// Return Yii base application configuration
return array(
    
    // Set application name
    'name' => 'YOnote ENGINE',
    // Set application charset
    'charset' => 'utf-8',
    // Set application base path
    'basePath' => ENGINE_PATH,
    
    'theme' => 'default',
    
    // Import engine components
    'import' => array(
        'application.base.*',
        'application.components.*',
        'application.components.models.*',
        'ext.*'
    ),
    
    'preload' => array(
        'mmanager',
        'wmanager',
        'settings',
        'pids'
    ),
    
    'behaviors' => array(
        'ApplicationConfigBehavior'
    ),
    
    // Components settigns
    'components' => array(
        'assetManager' => array(
            'basePath' => ENGINE_PATH.'/assets'
        ),
        // PIDs
        'pids' => array(
            'class' => 'CApplicationPids',
            'tableName' => '{{pid}}',
            'cacheTime' => 1000,
            'cacheComponentId' => 'cache',
            'dbComponentId' => 'db'
        ),
        // Settings
        'settings' => array(
            'class' => 'CApplicationSettings',
            'tableName' => '{{setting}}',
            'cacheTime' => 1000,
            'cacheComponentId' => 'cache',
            'dbComponentId' => 'db'
        ),
        // Cache settings
        'cache' => array(
            'class' => 'CFileCache',
            'cachePath' => ENGINE_PATH.'/cache'
        ),
        // Messages settings
        'messages' => array(
            'basePath' => ENGINE_PATH.'/languages'
        ),
        // Modules manager
        'mmanager' => array(
            'class' => 'CApplicationModules',
            'modulesPath' => THIS_PATH.'/modules',
            'dbComponentId' => 'db',
            'tableName' => '{{module}}',
            'cacheComponentId' => 'cache',
            'cacheTime' => 1000
        ),
        'wmanager' => array(
            'class' => 'CApplicationWidgets',
            'dbComponentId' => 'db',
            'tableName' => '{{widget}}',
            'cacheComponentId' => 'cache',
            'cacheTime' => 1000
        ),
        // Headers settings
        'headers' => array(
            'class' => 'CHeaders',
            'charset' => 'utf-8'
        ),
        // Database settings
        'db' => array(
            'class' => 'CDbConnection',
            'connectionString' => DB_STRING,
            'username' => DB_USER,
            'password' => DB_PASSWORD,
            'emulatePrepare' => true,
            'tablePrefix' => DB_PREFIX,
            'queryCacheID' => 'cache',
            'charset' => 'utf8'
        ),
        'themeManager' => array(
            'basePath' => THIS_PATH.'/templates'
        ),
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
            'assignmentTable' => '{{auth_assignment}}',
            'itemChildTable' => '{{auth_item_child}}',
            'itemTable' => '{{auth_item}}',
            'defaultRoles' => array('guest','authenticated')
        ),
        'user' => array(
            'class' => 'CApplicationUser',
            'loginUrl' => 'base/login',
            'returnUrl' => 'base/index',
            'dbComponentId' => 'db',
            'userTable' => '{{user}}'
        )
    ),
    
    // Application controllers path
    'controllerPath' => THIS_PATH.'/components/controllers',
    // Engine modules path
    'modulePath' => THIS_PATH.'/modules',
    // Extensions path
    'extensionPath' => ENGINE_PATH.'/extensions',
    // Default controller
    'defaultController' => 'base'
);
?>