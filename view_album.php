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
				<a href='view_song.php?song_name=<?php echo urlencode($song['song_name']); ?>&album_name=<?php echo urlencode($song['album_name']); ?>&artist_id=<?php echo $song['artist_id']; ?>'>
				<?php echo cleanSongName($song['song_name']); ?></a>
				</td>				
			</tr>

			<?php
		}
		
		?>
		</table>
		<?php
		if(isset($_POST['like']) || isset($_POST['love']) || isset($_POST['unlike']) || isset($_POST['unlove']))
		{
		
		$degree = 0;
		if (isset($_POST['like'])) $degree = 1;
		if (isset($_POST['love'])) $degree = 2;
		
			User::likeAlbum($_SESSION['userid'], $artist_id, $album_name, $degree);
			
			foreach($songs as $song)
			{
				User::likeSong($_SESSION['userid'], $artist_id, $album_name, $song['song_name'], $degree);			
			}
			
		}

		
		$rating = 0;
		if (array_key_exists('username', $_SESSION))
		{
			$albums = User::getAlbumsLikedBy($_SESSION['userid']);
			foreach($albums as $album)
			{
				if($row['album_name'] == $album['album_name'])
					$rating = $album['rating'];
			}
		}		
	
		if (array_key_exists('username', $_SESSION) && $rating == 0)
		{
		?>
		<form action='' method="post">
		<input type="image" SRC='img/like_button.png' name="like" value="Like">
		</form>
		<form action='' method="post">
		<input type="image" SRC='img/love_button.png' name="love" value="Love">
		</form>
			<?php
			
		}
		elseif (array_key_exists('username', $_SESSION) && $rating != 0)
		{
			echo ("<table border=0><tr><td>");
			showLikeOptionButtons('album',$rating,$album['artist_id'],$album['album_name'],null,true);
			echo ("</td></tr></table>");			
		
		}
		?>
		<?php
	}


}


$v = new ViewAlbum();

$v->render();



?>
