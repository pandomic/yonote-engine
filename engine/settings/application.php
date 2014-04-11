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
    // Setup default theme
    'theme' => 'default',
    
    // Import engine components
    'import' => array(
        'application.base.*',
        'application.components.*',
        'application.components.models.*',
        'application.components.widgets.*',
        'ext.*'
    ),
    
    // Preload some application components
    'preload' => array(
        'mmanager',
        'settings'
    ),
    
    // Application configuration
    'behaviors' => array(
        'ApplicationConfigBehavior'
    ),
    
    // Components settigns
    'components' => array(
        'request' => array(
            'csrfTokenName' => CSRF_TOKEN,
            'enableCsrfValidation' => true,
            'enableCookieValidation' => true
        ),
        // Database schema bilder
        'schema' => array (
            'class' => 'CApplicationSchema',
            'dbComponentId' => 'db'
        ),
        // Asset manager
        'assetManager' => array(
            'basePath' => THIS_PATH.'/assets'
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
        // Widgets manager
        'wmanager' => array(
            'class' => 'CApplicationWidgets',
            'dbComponentId' => 'db',
            'tableName' => '{{widget}}',
            'cacheComponentId' => 'cache',
            'cacheTime' => 1000
        ),
        // Headers
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
        // Theme manager
        'themeManager' => array(
            'basePath' => THIS_PATH.'/templates'
        ),
        // Auth manager
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
            'assignmentTable' => '{{auth_assignment}}',
            'itemChildTable' => '{{auth_item_child}}',
            'itemTable' => '{{auth_item}}',
            'defaultRoles' => array('guest','authenticated')
        ),
        // User object
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