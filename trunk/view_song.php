<?php

require_once('includes/global.php');
require_once('models/artist.php');
require_once('models/song.php');
require_once('includes/page.php');

class ViewSong extends Page
{

	function content()
	{
		$song_name = strip_tags($_GET['song_name']);
		$album_name = strip_tags($_GET['album_name']);
		$artist_id = strip_tags($_GET['artist_id']);
		
		$row = Song::getSongByNameArtistAndAlbum($song_name,$artist_id,$album_name);
		
		?>
		<h1><?php echo $song_name; ?></h1>
		<h2>by <a href='view_artist.php?artist_id= <?php echo $artist_id . "'>" . $row['name']; ?> </a> </h2>
		<h3>on <a href='view_album.php?artist_id=    <?php echo $artist_id . "&album_name=".$album_name . "'>" . $album_name; ?></a></h3>
		<p>Duration: <?php echo $row['duration']; ?></p>
		
		<?php
	}


}


$v = new ViewSong();

$v->render();



?>