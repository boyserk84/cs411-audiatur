<?php

require_once('includes/global.php');
require_once('includes/page.php');
require_once('models/artist.php');

class BrowseArtistsPage extends Page {
	var $title = "Browse Artists";

	function content() {
		// Todo: add search parameters & pagination
		$artists = Artist::getAll();

		?>
	
		<table class='browse'>
			<tr>				
				<th>Artist Name</th>
				<th>Year Founded</th>
			</tr>

		<?php

		foreach ($artists as $artist) {
			?>
			
			<tr>
				<td>
				<a href='view_artist.php?artist_id=<?php echo $artist['id']; ?>'>
				<?php echo $artist['name']; ?></a>
				</td>
				<td>
				<td>
				<?php echo $artist['founded_in']; ?>
				</td>
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
