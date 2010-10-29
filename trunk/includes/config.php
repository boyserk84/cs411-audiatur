<?php
/**
 * List of constants that control environment parameters, like settings
 * specific to the current server. If the defaults here don't work, 
 * override them in config.mine.php (create this file yourself, and
 * do not version it).
 */

if (file_exists('includes/config.mine.php')) {
	include 'includes/config.mine.php';
}



define('DEBUG',							true);


define('MYSQL_SERVER', 					'localhost');
define('MYSQL_USERNAME', 				'root');
define('MYSQL_PASSWORD', 				'');
define('MYSQL_DATABASE', 				'webmonkeys');



