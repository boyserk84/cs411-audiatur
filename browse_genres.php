<?php

require_once('includes/global.php');
require_once('includes/page.php');
require_once('models/genre.php');

class BrowseGenresPage extends Page {
	function content() {
		// Todo: add search parameters & pagination
		$genres = Genre::getAll();

		?>
	
		<table>
			<tr>
				<th>Genre Name</th>
			</tr>

		<?php

		foreach ($genres as $genre) {
			?>
			
			<tr>
				<td><?php echo $genre['name'];?></td>
			</tr>

			<?php
		}


		?>

		</table>

		<?php
	}
}

$b = new BrowseGenresPage();
$b->render();
