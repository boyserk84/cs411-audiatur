<?php
 
/**
 * Global start-up file for any and all pages. 
 */

// Require the necessary files.
require_once 'includes/config.php';  
require_once 'includes/database.php';

// Open up the database connection.
Database::initialize();

