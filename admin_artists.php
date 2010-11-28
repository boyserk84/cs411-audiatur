<?php

require 'includes/global.php';
require 'includes/page.php';
require 'includes/form.php';

require 'models/artist.php';
require 'models/album.php';

define('ACTION_DEFAULT', 1);
define('ACTION_ARTIST', 2);


class EditArtistsPage extends Page {
	function handleActions() {		
		$errors = array();
		$action = ACTION_DEFAULT;
		if (array_key_exists('add', $_POST)) {			
			$errors = Artist::insertFromPost();	
			$action = ACTION_DEFAULT;
		}elseif (array_key_exists('add_album', $_POST))
		{
			$errors = Album::insertFromPost();
			$action = ACTION_ARTIST;
		}
		 elseif (array_key_exists('edit', $_GET)) {
		//	$errors = Artist::updateFromPost();
			$action = ACTION_ARTIST;
		}

		if (sizeof($errors) > 0) {
			echo "<div class='errorbox'>Please correct the following errors:<ul>";
			foreach ($errors as $error) {
				echo "<li>" . $error;	
			}
			echo "</ul></div>";
		}

		return $action;
	}

	function content() {	
		$action = EditArtistsPage::handleActions();
		
		if ($action == ACTION_DEFAULT) {
			EditArtistsPage::manage();
		} elseif ($action == ACTION_ARTIST) {
			EditArtistsPage::edit((int)$_GET['edit']);
		}
	}		

	function edit($id) {
		$artist = Artist::getByArtistId($id);
		$albums = Album::getAllForArtist($id);
	
		?>
		<h1><?php echo $artist['name']; ?></h1>
		<?php
		echo "<h1>Add New Album</h1>";		
	 	
		// Print the add-artist form.
		start_form('');
		hidden_field('add_album', true);
		hidden_field('artist_id',$id);
		text_field("Album name:", 'album_name');
		text_field("Release date:", 'release_date');
		submit_button('Add Album');
		close_form();

		
		?>
		
		<h2>Albums:</h2>
		<table>
		<tr>
			<th>Album Name</th>
			<th>Release Date</th>
			<th>Options</th>
		</tr>
		<?php
	
		foreach ($albums as $album) {
			?>
		<tr>
			<td><?php echo $album['album_name']; ?></td>
			<td><?php echo $album['release_date']; ?></td>
			<td><a href='admin_albums.php?edit=<?php echo urlencode($album['album_name']); ?>&artist_id=<?php echo $id?>'>Edit</td>
		</tr>
			<?php
			
		}

		?>
		</table>
		<?php
	}

	function manage() {

		echo "<h1>Add New Artist</h1>";		
		
		// Print the add-artist form.
		start_form('');
		hidden_field('add', true);
		text_field("Artist name:", 'artist_name');
		text_field("Description:", 'description');
		text_field("Year founded:", 'year_founded');
		submit_button('Add Artist');
		close_form();

	
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
		

	}
}


$page = new EditArtistsPage();
$page->render();



