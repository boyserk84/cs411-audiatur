<?php

require 'includes/global.php';

class EditArtistsPage extends Page {
	function handleActions() {
		if (array_key_exists('add', $_POST)) {
			Artist::insertFromPost();	
		} elseif (array_key_exists('edit', $_POST)) {
			Artist::updateFromPost();
		}
	}

	function content() {
		echo "<h1>Manage Artists</h1>";

		handleActions();

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



