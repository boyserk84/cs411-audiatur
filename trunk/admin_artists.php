<?php

require 'includes/global.php';
require 'includes/page.php';
require 'includes/form.php';

require 'models/artist.php';

class EditArtistsPage extends Page {
	function handleActions() {		
		$errors = array();
		if (array_key_exists('add', $_POST)) {			
			$errors = Artist::insertFromPost();				
		} elseif (array_key_exists('edit', $_POST)) {
			$errors = Artist::updateFromPost();
		}

		if (sizeof($errors) > 0) {
			echo "<div class='errorbox'>Please correct the following errors:<ul>";
			foreach ($errors as $error) {
				echo "<li>" . $error;	
			}
			echo "</ul></div>";
		}
	}

	function content() {	
		EditArtistsPage::handleActions();
	
		echo "<h1>Manage Artists</h1>";

		?>
		<table>
			<tr>
				<th>Artist Name</th><th>Founded In</th><th>Description</th><th></th>
			</tr>
		<?php
		
		$artists = Artist::getAll();
		foreach ($artists as $artist) {
			?>
				<tr>
					<td>
						<?php echo $artist['name']; ?>
					</td>
					<td>
						<?php echo $artist['founded_in']; ?>
					</td>
					<td>
						<?php echo substr($artist['description'], 0, 100) . (strlen($artist['description'])>100 ? "..." : ""); ?>
					</td>
					<td>
						<a href='admin_artists.php?edit=<?php echo $artist['id'];?>'>Edit</a>
					</td>
				</tr>			
			<?php		
		}
		
		?>
		</table>
		<?php
		
		echo "<h1>Add New Artist</h1>";		
		
		// Print the add-artist form.
		start_form('');
		hidden_field('add', true);
		text_field("Artist name:", 'artist_name');
		text_field("Description:", 'description');
		text_field("Year founded:", 'year_founded');
		submit_button('Add Artist');
		close_form();

	}
}


$page = new EditArtistsPage();
$page->render();



