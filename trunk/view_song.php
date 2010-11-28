<?php

require_once('includes/global.php');
require_once('models/artist.php');
require_once('models/song.php');
require_once('includes/page.php');

class ViewSong extends Page
{

	function content()
	{
	
		if (!isset($_GET['song_name']) || !isset($_GET['album_name']) || !isset($_GET['artist_id']))
		{
			Page::printError("One or more required identifiers is missing. You may have reached this page in error.");
			return;
		}	
		
		
		$song_name = strip_tags($_GET['song_name']);
		$album_name = strip_tags($_GET['album_name']);
		$artist_id = strip_tags($_GET['artist_id']);
		
		
		$row = Song::getSongByNameArtistAndAlbum($song_name,$artist_id,$album_name);
		if (empty($row))
		{
			Page::printError("The song you are looking for does not exist - you may have reached this page in error.");
			return;
		}
		
		if(isset($_POST['like'])) {
			User::likeSong($_SESSION['userid'], $artist_id, $album_name, $song_name, 1);
		}
		if(isset($_POST['love'])) {
			User::likeSong($_SESSION['userid'], $artist_id, $album_name, $song_name, 2);
		}
		$liked = false;
		if (array_key_exists('username', $_SESSION))
		{
			$songs = User::getSongsLikedBy($_SESSION['userid']);
			foreach($songs as $song)
			{
				if($row['song_name'] == $song['song_name'])
					$liked = true;
			}
		}
		?>
		<h1><?php echo cleanSongName($song_name); ?></h1>
		<h2>by <a href='view_artist.php?artist_id= <?php echo $artist_id . "'>" . $row['name']; ?> </a> </h2>
		<h3>on <a href='view_album.php?artist_id=    <?php echo $artist_id . "&album_name=".$album_name . "'>" . $album_name; ?></a></h3>
		<p>Duration: <?php echo $row['duration']==0 ? "Unknown" : $row['duration']; ?></p>
		<?php
		if (array_key_exists('username', $_SESSION) && !$liked)
		{?>
		<form action='' method="post">
		<input type="image" SRC='img/like_button.png' name="like" value="Like">
		</form>
		<form action='' method="post">
		<input type="image" SRC='img/love_button.png' name="love" value="Love">
		</form>
			<?php
			
		}
		else if(array_key_exists('username', $_SESSION) && $liked)
		{
		?>
		<h4>Liked</h4>
		<?php
		}
		?>
		
		<?php
	}


}


$v = new ViewSong();

$v->render();



?>
