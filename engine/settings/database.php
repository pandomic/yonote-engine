<?php
/**
 * Database definitions
 *
 * @author Vlad Gramuzov <vlad.gramuzov@gmail.com>
 * @link http://
 * @copyright 2014
 * @license http://
 */

// Check access level
defined('YONOTE_ENGINE') or die('Hacking attempt!');

// Database user name
define('DB_USER','user');
// Database password
define('DB_PASSWORD','111111');
// Database name
define('DB_NAME','yonote');
// Database host
define('DB_HOST','localhost');
// Database type
define('DB_TYPE','mysql');
// Database tables prefix
define('DB_PREFIX','yonote_');
// Database connection string
define('DB_STRING',DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME)
?>