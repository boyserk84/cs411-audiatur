<?php

require_once('includes/global.php');
require_once('includes/page.php');
require_once('models/artist.php');
require_once('models/album.php');

class BrowseArtistsPage extends Page {
	var $title = "Browse Artists";

	function content() {
		// Todo: add search parameters & pagination
		$artists = Artist::getAll();
		
		if (array_key_exists('like_artist', $_GET) || array_key_exists('love_artist', $_GET))
		{
			if (!array_key_exists('username', $_SESSION))
			{
				Page::printError("You are not logged in. The requested action cannot be done.");
				return;
			}
			if (!isset($_GET['artist_id']))
			{
				Page::printError("One or more required identifiers is missing. You may have reached this page in error.");
				return;
			}		
			
			
			$artist_id = strip_tags($_GET['artist_id']);				
		
			$row = Artist::getArtistById($artist_id);
			if (DEBUG)
			{
				print_r($row);
			}
			if (empty($row))
			{
				Page::printError("The artist you are looking for does not exist - you may have reached this page in error.");
				return;
			}
			$albums = Artist::getAlbumsOfArtist($artist_id);
			if(array_key_exists('like_artist', $_GET))
			{
				User::likeArtist($_SESSION['userid'], $artist_id, 1);
				foreach($albums as $album){
					User::likeAlbum($_SESSION['userid'], $artist_id, $album['album_name'], 1);
					$songs = $songs = Album::getSongsOnAlbum($album['artist_id'],$album['album_name']);
					foreach($songs as $song){
						User::likeSong($_SESSION['userid'], $artist_id, $album['album_name'], $song['song_name'], 1);
					}
				}
			}
			else
			{
				User::likeArtist($_SESSION['userid'], $artist_id, 2);
				foreach($albums as $album){
					User::likeAlbum($_SESSION['userid'], $artist_id, $album['album_name'], 2);
					$songs = $songs = Album::getSongsOnAlbum($album['artist_id'],$album['album_name']);
					foreach($songs as $song){
						User::likeSong($_SESSION['userid'], $artist_id, $album['album_name'], $song['song_name'], 2);
					}
				}
			}
		}
		
		if (array_key_exists('username', $_SESSION))
			$artists_like = User::getArtistsLikedBy($_SESSION['userid']);
		else
			$artists_like = $artists;
		?>
	
		<table class='browse'>
			<tr>				
				<th>Artist Name</th>
				<th>Year Founded</th>
			</tr>

		<?php

		foreach ($artists as $artist) {
			$liked = false;
			foreach ($artists_like as $artist_like) {
				if($artist_like['artist_id'] == $artist['id'])
					$liked = true;
				}
			?>
			
			<tr>
				<td>
				<a href='view_artist.php?artist_id=<?php echo $artist['id']; ?>'>
				<?php echo $artist['name']; ?></a>
				</td>
				<td>
				<?php echo $artist['founded_in']; ?>
				</td>
				<?php
					if(!$liked){
					?>
				<td>
				<?php makeButton('artist','like',$artist['id']); ?>
				</td>
				<td>
				<?php makeButton('artist','love',$artist['id']); ?>
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

$b = new BrowseArtistsPage();
$b->render();
