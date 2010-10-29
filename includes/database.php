<?php
/**
 * Class to manage connecting and disconnecting from the database. For the sake
 * of allowing people to learn the mysql library itself, we won't perform any
 * wrapping functionality.
 */
 
require_once 'includes/config.php';
  
class Database {
	// Open the database connection.
	static function initialize() {	
		mysql_connect(MYSQL_SERVER, MYSQL_USERNAME, MYSQL_PASSWORD)
			or die("Could not select database.<br/><br/>" . (DEBUG ? mysql_error() : ""));
		mysql_select_db(MYSQL_DATABASE)
			or die("Could not select database.<br/><br/>" . (DEBUG ? mysql_error() : ""));
	}
	
	// Close the database connection.
	static function close() {
		mysql_close();
	}
	
	
	// Utility function to convert a DB result to a 2d array.
	static function resultToArray($result) {		
		$resArray = array();
		while ($row = mysql_fetch_assoc($result)) {
			$resArray[] = $row;
		}
		
		return $resArray;
	}
	
	// Utility function to convert a DB result which is expected to return a 
	// single row into a single row.
	static function resultToRow($result) {
		if (mysql_num_rows($result) < 1) { 
			return false; // Ends up being more useful than a blank array.
		} else {
			return mysql_fetch_assoc($result);
		}
	}
}
 
 // To initialize the database, in global.php, we do:
 //  Database::initialize();