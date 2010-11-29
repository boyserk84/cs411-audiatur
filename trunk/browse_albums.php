<?php

require_once('includes/global.php');
require_once('includes/page.php');
require_once('models/album.php');

class BrowseAlbumsPage extends Page {

	var $title = "Browse Albums";
	
	function content() {
		// Todo: add search parameters & pagination
		$albums = Album::getAll();
		
		if (array_key_exists('like_album', $_GET) || array_key_exists('love_album', $_GET)
		|| array_key_exists('unlike_album', $_GET) || array_key_exists('unlove_album', $_GET))
		{
		
			$degree = 0;
			if (array_key_exists('like_album', $_GET)) $degree = 1;
			if (array_key_exists('love_album', $_GET)) $degree = 2;
			
		
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
			
			//Set album to proper rating and rate all of its songs the same too.
			$songs = Album::getSongsOnAlbum($artist_id,$album_name);
			User::likeAlbum($_SESSION['userid'], $artist_id, $album_name, $degree);
			foreach($songs as $song)
			{
				User::likeSong($_SESSION['userid'], $artist_id, $album_name, $song['song_name'], $degree);
			}
		
		}
		
		if (array_key_exists('username', $_SESSION))
			$albums_like = User::getAlbumsLikedBy($_SESSION['userid']);
		else
			$albums_like = array();
		?>
	
		<table class='browse'>
			<tr>
				<th>Album</th>
				<th>Artist</th>
				<th>Date Released</th>
			</tr>

		<?php

		foreach ($albums as $album) {
			$rating = 0;
			if (array_key_exists('userid', $_SESSION)) {
				foreach ($albums_like as $album_like) {
					if($album_like['album_name'] == $album['album_name'] && $album['artist_id'] == $album_like['artist_id']) {
					$rating = $album_like['rating'];
					}
						
				}
			}
		
			?>
			
			<tr>
				<td>
				<a href='view_album.php?album_name=<?php echo urlencode($album['album_name']); ?>&artist_id=<?php echo $album['artist_id']; ?>'>
				<?php echo ($album['album_name']); ?></a>
				</td>
				<td>
				<?php 
				echo $album['artist_name']; ?>
				</td>
				<td>
				<?php echo $album['release_date']; ?>
				</td>
				<?php
				echo ("rating is " .$rating);
					if($rating==0){
					?>
				<td>
					<?php makeButton('album','like',$album['artist_id'],$album['album_name']); ?>
				</td>
				<td>
					<?php makeButton('album','love',$album['artist_id'],$album['album_name']); ?>
				</td>
				<?php
					}
					else
					{
					echo ("<td>");
					showLikeOptionButtons('album',$rating,$album['artist_id'],$album['album_name']);
					echo ("</td>");
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

$b = new BrowseAlbumsPage();
$b->render();
