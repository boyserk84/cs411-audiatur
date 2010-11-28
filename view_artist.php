<?php

require_once('includes/global.php');
require_once('models/artist.php');
require_once('models/album.php');
require_once('includes/page.php');

class ViewArtist extends Page
{

	function content()
	{
	
	
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
		
		?>
		<h1><?php echo $row['name']; ?></h1>
		<h3>Description:</h3><p><?php echo strtr($row['description'], array('&ldquo'=>'"', '&rdquo'=>'"', '&lsquo' => "'", '&rsquo' => "'")); ?>
		<h3>Genres:</h3>
		<p>
		<?php
		$genres = Artist::getGenresOfArtist($artist_id);
		foreach ($genres as $genre)
		{
			//todo: link to genre
			echo "<b>".$genre['name']."</b><br>";
		}
		?>
		<h3>Discography:</h3>
		<table border=0>
		<?php
		$albums = Artist::GetAlbumsOfArtist($artist_id);
		
		foreach ($albums as $album) {
			?>
			
			<tr>
				<td>
				<a href='view_album.php?album_name=<?php echo urlencode($album['album_name']); ?>&artist_id=<?php echo $artist_id; ?>'>
				<?php echo $album['album_name']; ?></a>
				</td>				
			</tr>

			<?php
		}
		
		?>
		</table>
		
		<?php
		if(isset($_POST['like']) || isset($_POST['love'])) {
			if(isset($_POST['like']))
				User::likeArtist($_SESSION['userid'], $artist_id, 1);
			else
				User::likeArtist($_SESSION['userid'], $artist_id, 2);
			foreach($albums as $album)
			{
				if(isset($_POST['like']))
					User::likeAlbum($_SESSION['userid'], $artist_id, $album['album_name'], 1);
				else
					User::likeAlbum($_SESSION['userid'], $artist_id, $album['album_name'], 2);
				$songs = Album::getSongsOnAlbum($artist_id,$album['album_name']);
		
				foreach ($songs as $song) {
					if(isset($_POST['like']))
						User::likeSong($_SESSION['userid'], $artist_id, $album['album_name'], $song['song_name'], 1);
					else
						User::likeSong($_SESSION['userid'], $artist_id, $album['album_name'], $song['song_name'], 2);
				}
			}
			
		}
		
		$liked = false;
		if (array_key_exists('username', $_SESSION))
		{
			$artists = User::getArtistsLikedBy($_SESSION['userid']);
			foreach($artists as $artist)
			{
				if($row['id'] == $album['artist_id'])
					$liked = true;
			}
		}
		
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


$v = new ViewArtist();

$v->render();



?>
