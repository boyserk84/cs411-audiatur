<?php
 
/**
 * Global start-up file for any and all pages. 
 */

// Require the necessary files.
require_once 'includes/config.php';  
require_once 'includes/database.php';

require_once 'models/user.php';

// To be moved out later.
function cleanSongName($str) {
	return strip_tags(preg_replace('/^\d+\.?/',"",trim($str)));
}

// Open up the database connection.
Database::initialize();

// Initialize session.
session_start();
if (!array_key_exists('username', $_SESSION)) {
	// Not logged in.
	$loggedIn = false;

	if (array_key_exists('username', $_POST)) {
		$u = User::getUserByInformation($_POST['username'], $_POST['password']);
		if ($u) {
			$loggedIn = true;
			$_SESSION['username'] = $u['user_name'];
			$_SESSION['userid'] = $u['user_id'];
		}
	}
} else {
	// Logged in.
	$loggedIn = true;

	if (array_key_exists('logout', $_GET)) {
		unset($_SESSION['username']);
		unset($_SESSION['userid']);
		$loggedIn = false;
	}
}



