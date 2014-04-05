<?php
/**
 * Main configuration file
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://
 * @copyright 2014
 * @license http://
 */

// Check access level
defined('YONOTE_ENGINE') or die('Hacking attempt!');

# System definitions

// YOnote ENGINE version
define('ENGINE_VERSION','1.0');
// YOnote ENGINE system path
define('ENGINE_PATH',dirname(__FILE__).DIRECTORY_SEPARATOR.'..');
// Settings path
define('SETTINGS_PATH',ENGINE_PATH.DIRECTORY_SEPARATOR.'settings');
// Current path
defined('THIS_PATH') or define('THIS_PATH',ENGINE_PATH);
// YOnote ENGINE modules path
define('ENGINE_MODULES',ENGINE_PATH.DIRECTORY_SEPARATOR.'modules');

// Database definitions
require_once(SETTINGS_PATH.'/database.php');
// Load base engine interfaces
require_once(ENGINE_PATH.'/base/interfaces.php');
?>