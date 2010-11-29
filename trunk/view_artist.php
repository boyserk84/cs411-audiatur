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
		if(isset($_POST['like']) || isset($_POST['love']) || isset($_POST['unlike']) || isset($_POST['unlove']))
		{
		
			$degree = 0;
			if (isset($_POST['like'])) $degree = 1;
			if (isset($_POST['love'])) $degree = 2;
			
			User::likeArtist($_SESSION['userid'], $artist_id, $degree);
			
			foreach($albums as $album)
			{
				User::likeAlbum($_SESSION['userid'], $artist_id, $album['album_name'], $degree);
				$songs = Album::getSongsOnAlbum($artist_id,$album['album_name']);
		
				foreach ($songs as $song) {
					User::likeSong($_SESSION['userid'], $artist_id, $album['album_name'], $song['song_name'], $degree);
					
				}
			}
			
		}
		
	
		
		$rating = 0;
		if (array_key_exists('username', $_SESSION))
		{
			$artists = User::getArtistsLikedBy($_SESSION['userid']);
			foreach($artists as $artist)
			{
				if($row['id'] == $artist['artist_id'])
					$rating = $artist['rating'];
			}
		}

		if (array_key_exists('username', $_SESSION) && !$rating)
		{?>
		<form action='' method="post">
		<input type="image" SRC='img/like_button.png' name="like" value="Like">
		</form>
		<form action='' method="post">
		<input type="image" SRC='img/love_button.png' name="love" value="Love">
		</form>
			<?php
			
		}
		elseif(array_key_exists('username', $_SESSION) && $rating)
		{
			echo ("</table border='0'><tr><td>");
			showLikeOptionButtons('artist',$rating,$artist['id'],null,null,true);
			echo ("</td></tr></table>");			
		}
		?>
		
		<?php
	}


}


$v = new ViewArtist();

$v->render();



?>
