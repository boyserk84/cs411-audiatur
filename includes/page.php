<?php
/** 
 * Base class for all website pages.
 */
 
class Page {
	var $title = "";
	// Print the header.
	function header() {

		global $loggedIn;

		?>
<html>
	<head>
		<title>Audiatur</title>
		<link rel='stylesheet' href='css/main.css' />
	</head>
	<body>
		<div class='topheader'>
			<div class='loginbox'>
				<?php if (!$loggedIn) { ?>
				<form action='' method='post'>
				<b>Login to rate songs:</b><br/>
				username: <input type='text' name='username' value='' size='8'/><br/>
				password: <input type='password' name='password' value='' size='8'/><br/>
				<input type='submit' value='Login'/> | <a href='register.php'>Register</a>
				</form>
				<?php } else { ?>
				Welcome, <b><?php echo $_SESSION['username']; ?></b>.<br/><br/>
				<a href='?logout'>Log out</a>
				<?php } ?>
			</div>
			<img src='img/audiatur_logo.png'>
			<div class='linkbox'><a href='index.php'>Home</a> | <a href='browse_songs.php'>Browse Songs</a> | <a href='browse_albums.php'>Browse Albums</a> | <a href='browse_artists.php'>Browse Artists</a> | <a href='browse_genres.php'>Browse Genres</a> | <a href='account.php'>My Account</a> | <a href='about.php'>About</a></div>
		</div>
		
		<h2><?php echo $this->title; ?></h2>
		
		<?php
	}
	
	// Print the page content.
	function content() {
		/* Reimplement this function in subclasses. */
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

