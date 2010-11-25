<?php

require_once('includes/global.php');
require_once('includes/page.php');
require_once('models/album.php');

class BrowseSongsPage extends Page {

	var $title = "Browse Albums";
	
	function content() {
		// Todo: add search parameters & pagination
		$albums = Album::getAll();
		
		if (array_key_exists('like_album', $_GET) || array_key_exists('love_album', $_GET))
		{
			if (!array_key_exists('username', $_SESSION))
			{
				Page::printError("You are not logged in. The requested action cannot be done.");
				return;
			}
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
			$songs = Album::getSongsOnAlbum($artist_id,$album_name);
			if(array_key_exists('like_album', $_GET))
			{
				User::likeAlbum($_SESSION['userid'], $artist_id, $album_name, 1);
				foreach($songs as $song)
				{
					User::likeSong($_SESSION['userid'], $artist_id, $album_name, $song['song_name'], 1);
				}
			}
			else
			{
				User::likeAlbum($_SESSION['userid'], $artist_id, $album_name, 2);
				foreach($songs as $song)
				{
					User::likeSong($_SESSION['userid'], $artist_id, $album_name, $song['song_name'], 2);
				}
			}
		}
		
		if (array_key_exists('username', $_SESSION))
			$albums_like = User::getAlbumsLikedBy($_SESSION['userid']);
		else
			$albums_like = $albums;
		?>
	
		<table>
			<tr>
				<th>Album</th>
				<th>Artist</th>
				<th>Date Released</th>
			</tr>

		<?php

		foreach ($albums as $album) {
			$liked = false;
			foreach ($albums_like as $album_like) {
				if($album_like['album_name'] == $album['album_name'])
					$liked = true;
				}
			?>
			
			<tr>
				<td>
				<a href='view_album.php?album_name=<?php echo $album['album_name']; ?>&artist_id=<?php echo $album['artist_id']; ?>'>
				<?php echo $album['album_name']; ?></a>
				</td>
				<td>
				<?php 
				echo $album['artist_name']; ?>
				</td>
				<td>
				<?php echo $album['release_date']; ?>
				</td>
				<?php
					if(!$liked){
					?>
				<td>
				<a href='?like_album&album_name=<?php echo $album['album_name']; ?>&artist_id=<?php echo $album['artist_id']; ?>'>Like</a>
				</td>
				<td>
				<a href='?love_album&album_name=<?php echo $album['album_name']; ?>&artist_id=<?php echo $album['artist_id']; ?>'>Love</a>
				</td>
				<?php
					}
					else
					{
					?>
				<td>
				Liked
				</td>
				<?php
					}
					?>
				
			</tr>

			<?php
		}


		?>

		</table>

		<?php
	}
}

$b = new BrowseSongsPage();
$b->render();
