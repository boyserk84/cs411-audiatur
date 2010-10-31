<?php

require_once('includes/global.php');
require_once('models/artist.php');
require_once('models/album.php');
require_once('models/song.php');
require_once('includes/page.php');

class ViewAlbum extends Page
{

	function content()
	{
	
	
		if (!isset($_GET['album_name']) || !isset($_GET['artist_id']))
		{
			Page::printError("One or more required identifiers is missing. You may have reached this page in error.");
			return;
		}			
		
	
		$album_name = strip_tags($_GET['album_name']);
		$artist_id = strip_tags($_GET['artist_id']);
		
		
		$row = Album::getByNameAndArtist($album_name,$artist_id);
		if (DEBUG)
		{
			print_r($row);
		}
		if (empty($row))
		{
			Page::printError("The album you are looking for does not exist - you may have reached this page in error.");
			return;
		}
		
		?>
		<h1><?php echo $album_name; ?></h1>
		<h2>by <a href='view_artist.php?artist_id= <?php echo $artist_id . "'>" . $row['name']; ?> </a> </h2>
		<h3>Track Listing:</h3>
		<table border=0>
		<?php
		$songs = Album::getSongsOnAlbum($artist_id,$album_name);
		
		foreach ($songs as $song) {
			?>
			
			<tr>
				<td>
				<a href='view_song.php?song_name=<?php echo $song['song_name']; ?>&album_name=<?php echo $song['album_name']; ?>&artist_id=<?php echo $song['artist_id']; ?>'>
				<?php echo $song['song_name']; ?></a>
				</td>				
			</tr>

			<?php
		}
		
		?>
		</table>
		
		<?php
	}


}


$v = new ViewAlbum();

$v->render();



?>