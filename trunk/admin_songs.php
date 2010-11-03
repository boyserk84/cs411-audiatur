<?php

require 'includes/global.php';
require 'includes/page.php';
require 'includes/form.php';

require 'models/artist.php';
require 'models/album.php';
require 'models/song.php';

define('ACTION_DEFAULT', 1);
define('ACTION_SONG', 2);


class EditSongsPage extends Page {
	function handleActions() {		
		$errors = array();
		$action = ACTION_DEFAULT;
		if (array_key_exists('update', $_POST)) {			
			$errors = Song::updateFromPost();	
			$action = ACTION_SONG;			
		} elseif (array_key_exists('edit', $_GET)) {

			$action = ACTION_SONG;
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
		$action = EditSongsPage::handleActions();
		
		if ($action == ACTION_DEFAULT) {
			EditSongsPage::manage();
		} elseif ($action == ACTION_SONG) {
			EditSongsPage::edit($_GET['album_name'],(int)$_GET['artist_id'],$_GET['edit']);
		}
	}		
	
	function manage()
	{
		echo("Nothing here yet.");
	}
	
	function edit($album_name,$artist_id,$song_name)
	{
	
		$song_info = Song::getSongByNameArtistAndAlbum($song_name,$artist_id,$album_name);
		?>
		<h1>Edit Song</h1>
		
		<?php // Print the add-song form.
		start_form('');
		hidden_field('update', true);
		hidden_field('album_name', $album_name);
		hidden_field('old_name', $song_name);
		hidden_field('artist_id', $artist_id);
		text_field("Song name:", 'song_name',$song_name);
		text_field("Duration:", 'duration',$song_info['duration']);
		
		submit_button('Update Song');
		close_form();
			
		
	
	}
	
}

$s = new EditSongsPage();
$s->render();