<?php

require_once('includes/global.php');
require_once('includes/page.php');
require_once('models/song.php');

class BrowseSongsPage extends Page {
	
	var $title = "Browse Songs";

	function content() {
		// Todo: add search parameters & pagination
		$songs = Song::getAllSongs();

		?>
	
		<table class='browse'>
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
				<a href='view_song.php?song_name=<?php echo $song['song_name']; ?>&album_name=<?php echo $song['album_name']; ?>&artist_id=<?php echo $song['artist_id']; ?>'>
				<?php echo $song['song_name']; ?></a>
				</td>
				<td>
				<a href='view_album.php?album_name=<?php echo $song['album_name']; ?>&artist_id=<?php echo $song['artist_id']; ?>'>
				<?php echo $song['album_name']; ?></a>
				</td>
				<td>
				<a href='view_artist.php?artist_id=<?php echo $song['artist_id']; ?>'><?php echo $song['name']; ?></a>				
				
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