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

function makeButton($type='song',$degree='like',$artist_id=NULL,$album_name=NULL,$song_name=NULL)
{
	if ($type == "song")
	{
	?>
	<a href='?<?php echo $degree; ?>_song&song_name=<?php echo $song_name; ?>&album_name=<?php echo $album_name; ?>&artist_id=<?php echo $artist_id; ?>'><img border='0' src="img/<?php echo $degree; ?>_button.png" /></a>
    <?php
	}
	
	if ($type == "album")
	{
		?>
	<a href='?<?php echo $degree;?>_album&album_name=
	<?php echo urlencode($album_name); ?>&artist_id=<?php echo $artist_id; ?>'><img border='0' src="img/<?php echo $degree; ?>_button.png" /></a>
    <?php
	}
	
	if ($type == "artist")
	{
		?>
			<a href='?<?php echo $degree; ?>_artist&artist_id=<?php echo $artist_id; ?>'><img border ='0' src="img/<?php echo $degree; ?>_button.png" /></a>
		<?php
	}
	

}

function showLikeOptionButtons($type='song',$rating=1,$artist_id=NULL,$album_name=NULL,$song_name=NULL)
{

	//Nothing, Liked or Loved?
	if ($rating == 0) return;
	
	if ($rating == 1)
	{
		$degree1 = 'unlike';
		$degree2 = 'love';
	}
	elseif ($rating == 2)
	{
		$degree1 = 'like';
		$degree2 = 'unlove';		
	}

	//Song, Album, or Artist? Add relevant info.
	
	if ($type == "song")
	{
		
		
		?>
		<a href='?<?php echo $degree1; ?>_song&song_name=<?php echo $song_name; ?>&album_name=<?php echo $album_name; ?>&artist_id=<?php echo $artist_id; ?>'><img border='0' src="img/<?php echo $degree1; ?>_button.png" /></a>
		<a href='?<?php echo $degree2; ?>_song&song_name=<?php echo $song_name; ?>&album_name=<?php echo $album_name; ?>&artist_id=<?php echo $artist_id; ?>'><img border='0' src="img/<?php echo $degree2; ?>_button.png" /></a>
		<?php
	}
	
	if ($type == "album")
	{
		?>
		<a href='?<?php echo $degree1;?>_album&album_name=
		<?php echo urlencode($album_name); ?>&artist_id=<?php echo $artist_id; ?>'><img border='0' src="img/<?php echo $degree1; ?>_button.png" /></a>
	
		<a href='?<?php echo $degree2;?>_album&album_name=
		<?php echo urlencode($album_name); ?>&artist_id=<?php echo $artist_id; ?>'><img border='0' src="img/<?php echo $degree2; ?>_button.png" /></a>
	
		<?php
	}
	
	if ($type == "artist")
	{
		?>
			<a href='?<?php echo $degree1; ?>_artist&artist_id=<?php echo $artist_id; ?>'><img border ='0' src="img/<?php echo $degree1; ?>_button.png" /></a>
		<?php
		?>
			<a href='?<?php echo $degree2; ?>_artist&artist_id=<?php echo $artist_id; ?>'><img border ='0' src="img/<?php echo $degree2; ?>_button.png" /></a>
		<?php
	}
	
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
		session_destroy();
	}
}



