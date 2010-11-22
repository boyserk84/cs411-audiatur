<?php
/**
 * List of constants that control environment parameters, like settings
 * specific to the current server. If the defaults here don't work, 
 * override them in config.mine.php (create this file yourself, and
 * do not version it).
 */

error_reporting(E_ERROR);

if (file_exists('includes/config.mine.php')) {
	include 'includes/config.mine.php';
}



define('DEBUG',							false);


define('MYSQL_SERVER', 					'localhost');
if (!defined('MYSQL_USERNAME'))
	define('MYSQL_USERNAME', 				'root');
if (!defined('MYSQL_PASSWORD'))
	define('MYSQL_PASSWORD', 				'');
if (!defined('MYSQL_DATABASE'))
	define('MYSQL_DATABASE', 				'audiatur');	



