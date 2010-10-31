<?php

require_once('includes/global.php');
require_once('includes/page.php');
require_once('models/song.php');

class BrowseSongsPage extends Page {
	function content() {
		// Todo: add search parameters & pagination
		$songs = Song::getAllSongs();

		?>
	
		<table>
			<tr>
				<th>Song Name</th>
				<th>Album</th>
				<th>Artist</th>
			</tr>

		<?php

		foreach ($songs as $song) {
			?>
			
			<tr>
				<td>
				<?php echo $song['song_name']; ?>
				</td>
				<td>
				<?php echo $song['album_name']; ?>
				</td>
				<td>
				<?php 
				//at the moment, this field is not properly named when retrieved. Need to fix query
				echo $song['name']; ?>
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