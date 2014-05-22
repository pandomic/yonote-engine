<?php
/**
 * Application configuration file.
 * 
 * Yii framework configuration.
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
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
        'application.components.*',
        'application.components.widgets.*',
        'application.components.behaviors.*',
        'application.models.*',
        'ext.*'
    ),
    
    // Preload some application components
    'preload' => array(
        'mmanager',
        'settings'
    ),
    
    // Application configuration
    'behaviors' => array(
        'ConfigBehavior'
    ),
    
    // Components settigns
    'components' => array(
        // URL manager settings
        'urlManager' => array(
            'class' => 'CApplicationUrlManager',
            'showScriptName' => false
        ),
        // Request settings
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
            'basePath' => ASSETS_PATH,
            'baseUrl' => ASSETS_PATH_URL
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
            'cachePath' => CACHE_PATH
        ),
        // Modules manager
        'mmanager' => array(
            'class' => 'CApplicationModules',
            'modulesPath' => MODULES_PATH,
            'dbComponentId' => 'db',
            'tableName' => '{{module}}',
            'cacheComponentId' => 'cache',
            'cacheTime' => 1000
        ),
        // Headers
        'headers' => array(
            'class' => 'CApplicationHeaders',
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
            'loginUrl' => array('base/login'),
            'returnUrl' => array('base/index'),
            'dbComponentId' => 'db',
            'userTable' => '{{user}}'
        ),
        // Default error action
        'errorHandler' => array(
            'errorAction' => 'base/error'
        )
    ),
    
    // Application controllers path
    'controllerPath' => CONTROLLERS_PATH,
    // Engine modules path
    'modulePath' => MODULES_PATH,
    // Extensions path
    'extensionPath' => EXTENSIONS_PATH,
    // Default controller
    'defaultController' => 'base'
);
?>