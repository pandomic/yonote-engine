<?php
/**
 * Application configuration file.
 *
 * Constants definitions.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

// Check access level
defined('YONOTE_ENGINE') or die('Hacking attempt!');

/**
 * Enable Yii debug mode (should be removed in production)
 */
define('YII_DEBUG',true);

# System definitions

// YOnote ENGINE version
define('ENGINE_VERSION','1.0');
// YOnote ENGINE system path
define('ENGINE_PATH',realpath(__DIR__.DIRECTORY_SEPARATOR.'..'));
// Administrative path
define('ADMIN_PATH',realpath(ENGINE_PATH.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'admin'));
// Settings path
define('SETTINGS_PATH',ENGINE_PATH.DIRECTORY_SEPARATOR.'settings');
// Current path
defined('THIS_PATH') or define('THIS_PATH',ENGINE_PATH);
// YOnote ENGINE modules path
define('MODULES_PATH',THIS_PATH.DIRECTORY_SEPARATOR.'modules');
// Uploads path
define('UPLOADS_PATH',ENGINE_PATH.'/uploads');
define('UPLOADS_PATH_URI','engine/uploads');
// CSRF token name
define('CSRF_TOKEN','YE_CSRF');

// Database definitions
require_once(SETTINGS_PATH.'/database.php');
// Load base engine interfaces
require_once(ENGINE_PATH.'/components/interfaces.php');
?>