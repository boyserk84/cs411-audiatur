<?php
/** 
 * Base class for all website pages.
 */
 
class Page {
	// Print the header.
	function header() {
		// This is the fast way to print HTML:
		?>
<html>
	<head>
		<title>ACM Webmonkeys</title>
		<link rel='stylesheet' href='css/main.css' />
	</head>
	<body>
		<h1>ACM Webmonkeys</h1>
		<a href='welcome.php'>Home</a> <a href='members.php'>Members</a> <a href='tutorials.php'>Tutorials</a> <a href='projects.php'>Projects</a> <a href='contact.php'>Contact</a>
		
		
		
		<?php
	}
	
	// Print the page content.
	function content() {
		/* Reimplement this function in subclasses! */
	}
	
	// Print the footer of the page, wrapping things up.
	function footer() {		
		// This is the slow way to print HTML.
		echo "</body>" . "\n";
		echo "</html>" . "\n";
	}
	
	// Render the page.
	function render() {
		$this->header();
		$this->content();
		$this->footer();
	}
}

