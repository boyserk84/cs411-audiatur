<?php

require 'includes/global.php'
require 'models/song.php'

class BrowseSongsPage extends Page {
	function content() {
		// Todo: add search parameters & pagination
		$songs = Song::getAll();

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
				

			<?php
		}


		?>

		</table>

		<?php
	}
}
