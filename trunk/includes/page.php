<?php
/** 
 * Base class for all website pages.
 */
 
class Page {
	var $title = "";
	// Print the header.
	function header() {
		// This is the fast way to print HTML:
		?>
<html>
	<head>
		<title>Audiatur</title>
		<link rel='stylesheet' href='css/main.css' />
	</head>
	<body>
		<div class='topheader'>
			<img src='img/audiatur_logo.png'>
			<div class='linkbox'><a href='index.php'>Home</a> | <a href='browse_songs.php'>Browse Songs</a> | <a href='browse_albums.php'>Browse Albums</a> | <a href='browse_artists.php'>Browse Artists</a> | <a href='browse_genres.php'>Browse Genres</a> | <a href='account.php'>My Account</a> | <a href='about.php'>About</a></div>
		</div>
		
		<h1><?php echo $this->title; ?></h1>
		
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
	
	function printError($error) {
	echo "<div style='width:50%;border:1px dashed red;background:#FFFFCC'>$error</div>";
	
	}
	
	
}

