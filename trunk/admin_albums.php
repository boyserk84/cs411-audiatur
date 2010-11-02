<?php

require 'includes/global.php';
require 'includes/page.php';
require 'includes/form.php';

require 'models/artist.php';
require 'models/album.php';
require 'models/song.php';

define('ACTION_DEFAULT', 1);
define('ACTION_ALBUM', 2);


class EditAlbumsPage extends Page {
	function handleActions() {		
		$errors = array();
		$action = ACTION_DEFAULT;
		if (array_key_exists('add', $_POST)) {			
			$errors = Album::insertFromPost();	
			$action = ACTION_DEFAULT;			
		} elseif (array_key_exists('edit', $_GET)) {

			$action = ACTION_ALBUM;
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
	
	
//add content function


function edit($album_name,$artist_id) {
	//todo: pull album info, song list...iterate
	?>
	<h1>Edit Artist <?php echo $artist['name']; ?></h1>
	
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
		<td><a href='admin_albums.php?edit=<?php echo $album['album_name']; ?>&artist_id=<?php echo $id?>'></td>
	</tr>
		<?php
		
	}

	?>
	</table>
	<?php
}
	
	
	
	
?>