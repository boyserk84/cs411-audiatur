<?php

require 'includes/global.php';
require 'includes/page.php';
require 'includes/form.php';

require 'models/artist.php';
require 'models/album.php';
require 'models/song.php';

define('ACTION_DEFAULT', 1);
define('ACTION_ALBUM', 2);
define('ACTION_DELETED', 3);


class EditAlbumsPage extends Page {
	function handleActions() {		
		$errors = array();
		$action = ACTION_DEFAULT;
		if (array_key_exists('add', $_POST)) {			
			$errors = Song::insertFromPost();	
			$action = ACTION_ALBUM;			
		} elseif (array_key_exists('editpost', $_POST)) {
			$errors = Album::updateFromPost();
			$action = ACTION_ALBUM;
		}  elseif (array_key_exists('edit', $_GET)) {
			$action = ACTION_ALBUM;
		} elseif (array_key_exists('delete', $_GET)) {
			Album::delete($_GET['delete'], $_GET['artist_id']);
			$action = ACTION_DELETED;
		}

		if (sizeof($errors) > 0) {
			echo "<div class='errorbox'>";
			foreach ($errors as $error) {
				echo "<li>" . $error;	
			}
			echo "</ul></div>";
		}

		return $action;
	}
	
	

	function content() {	
		$action = EditAlbumsPage::handleActions();
		
		if ($action == ACTION_DEFAULT) {
			EditAlbumsPage::manage();
		} elseif ($action == ACTION_ALBUM) {
			//here, edit is album name
			EditAlbumsPage::edit($_GET['edit'],(int)$_GET['artist_id']);
		} elseif ($action == ACTION_DELETED) {
			echo "This album has now been deleted. <a href='admin_artists.php?edit=" . $_GET['artist_id'] . "'>Go back</a>";
		}
	}		

	function manage()
	{
		echo("Nothing here yet.");
	}

	function edit($album_name,$artist_id) {
	
	//pull album info, song list...iterate
		$album_info = Album::getByNameAndArtist($album_name,$artist_id);
		$songs_on_album = Album::getSongsOnAlbum($artist_id,$album_name);
		
		?>
		<h1>Edit Album <?php echo $album_info['album_name']; ?></h1>
		<?php
		start_form('?edit=' . urlencode($album_info['album_name']) . ' &artist_id=' . $album_info['artist_id']);
		hidden_field('editpost', true);
		hidden_field('artist_id', $album_info['artist_id']);
		text_field("Album name", 'album_name', $album_info['album_name']);
		text_field("Release date", 'release_date', $album_info['release_date']);
		//text_area("Description", 'description', $album_info['description']);
		submit_button('Edit Album');
		close_form(); 
		?>
		<h2>Tracks:</h2>
		<table>
		<tr>
			<th>Track Name</th>
			<th>Duration</th>
			<th>Options</th>
		</tr>
		<?php

		foreach ($songs_on_album as $song) {
			?>
		<tr>
			<td><?php echo $song['song_name']; ?></td>
			<td><?php echo $song['duration']; ?></td>
			<td><a href='admin_songs.php?edit=<?php echo urlencode($song['song_name']); ?>&album_name=<?php echo urlencode($album_name);?>&artist_id=<?php echo $artist_id;?>'>Edit</a> | 
			<a href='admin_songs.php?delete=<?php echo urlencode($song['song_name']); ?>&album_name=<?php echo urlencode($album_name);?>&artist_id=<?php echo $artist_id;?>'>Delete</a></td>
		</tr>
			<?php			
		}			

		echo "		</table>";
		
		echo "<h2>Add New Song</h2>";		
		
		// Print the add-song form.
		start_form('');
		hidden_field('add', true);
		hidden_field('album_name', $album_name);
		hidden_field('artist_id', $artist_id);
		text_field("Song name:", 'song_name');
		text_field("Duration:", 'duration');
		
		submit_button('Add Song');
		close_form();
		

	}
	
}

$page = new EditAlbumsPage();
$page->render();

	
	
?>