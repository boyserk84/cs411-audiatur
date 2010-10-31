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
		<h3>Description:</h3><p><?php echo $row['description']; ?>
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
				<a href='view_album.php?album_name=<?php echo $album['album_name']; ?>&artist_id=<?php echo $artist_id; ?>'>
				<?php echo $album['album_name']; ?></a>
				</td>				
			</tr>

			<?php
		}
		
		?>
		</table>
		
		<?php
	}


}


$v = new ViewArtist();

$v->render();



?>