<?php
/**
 * Application configuration file.
 *
 * Database settings.
 * 
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://yonote.org
 * @copyright 2014 Vlad Gramuzov
 * @license http://yonote.org/license.html
 */

// Check access level
defined('YONOTE_ENGINE') or die('Hacking attempt!');

// Database user name
define('DB_USER','{user}');
// Database password
define('DB_PASSWORD','{password}');
// Database name
define('DB_NAME','{dbname}');
// Database host
define('DB_HOST','{host}');
// Database type
define('DB_TYPE','{type}');
// Database tables prefix
define('DB_PREFIX','{prefix}');
// Database connection string
define('DB_STRING',DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME)
?>