<?php

require_once('includes/global.php');
require_once('includes/page.php');
require_once('models/album.php');

class BrowseSongsPage extends Page {

	var $title = "Browse Albums";
	
	function content() {
		// Todo: add search parameters & pagination
		$albums = Album::getAll();

		?>
	
		<table>
			<tr>
				<th>Album</th>
				<th>Artist</th>
				<th>Date Released</th>
			</tr>

		<?php

		foreach ($albums as $album) {
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
