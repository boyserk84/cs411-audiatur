<?php
/**
 * Example of a page.
 */
 
require_once 'includes/global.php';
require_once 'includes/page.php';

class DummyPage extends Page {
	function content() {
		echo "Welcome!";
	}
}

$page = new DummyPage();
$page->render();
