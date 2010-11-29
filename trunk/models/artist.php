<?php

require_once('includes/model.php');
require_once('includes/database.php');

class Artist extends Model 
{
	function getAll($keyword='')
	{
		$qry = "SELECT * FROM artists";
		if ($keyword) {
			$keyword = mysql_real_escape_string($keyword);
			$qry .= " WHERE name LIKE '%$keyword%'";
		}
		
		$res = mysql_query($qry);
		$res_array = Database::resultToArray($res);
		if (DEBUG) 
		{
			echo "$qry  returned results: <br>";
			print_r($res_array);			
		}
		return $res_array;
	}
	
	function getByArtistId($id) {
		$id = (int)$id;
		$sql = "SELECT * FROM artists WHERE id=$id";
		$qry = mysql_query($sql) or die(mysql_error());
		return (Database::resultToRow($qry));
	}

	function getGenresOfArtist($id)
	{
		$id = mysql_real_escape_string($id);
		$qry = "SELECT * FROM genres LEFT JOIN artists_playing_genres 
				ON genres.name = artists_playing_genres.genre_name
				WHERE artist_id = $id";
		
		$res = mysql_query($qry);
		$res_array = Database::resultToArray($res);
		if (DEBUG) 
		{
			echo "$qry  returned results: <br>";
			print_r($res_array);			
		}
		return $res_array;
		
	}
	
	function getAlbumsOfArtist($id)
	{
		$qry = "SELECT * FROM albums LEFT JOIN artists ON artists.id = albums.artist_id WHERE artists.id = $id";
		$res = mysql_query($qry);
		$res_array = Database::resultToArray($res);
		if (DEBUG) 
		{
			echo "$qry  returned results: <br>";
			print_r($res_array);			
		}
		return $res_array;
	}
	
	function addGenreToArtist($genre_name,$artist_id)
	{
		$genre_name = mysql_real_escape_string($genre_name);
		$artist_id = mysql_real_escape_string($artist_id);
		
		$qry = "INSERT INTO `artists_playing_genres` (artist_id,genre_name) VALUES($artist_id,$genre_name)";
		$res = mysql_query($qry);
		if (DEBUG)
		{
			echo "Inserting with query: $qry <br>";
		}
		
	}
	
	function getArtistById($id)
	{	
		$id = mysql_real_escape_string($id);
		$qry = "SELECT * FROM artists WHERE id=$id";
		$res = mysql_query($qry);
		$res_row = Database::resultToRow($res);
		if (DEBUG) 
		{
			echo "$qry  returned results: <br>";
			print_r($res_row);
		}
		return $res_row;
	
	}


	function insertFromPost() {
		Artist::insertFromData($_POST);
	}

	function insertFromData($data) {
		$cName = mysql_real_escape_string($data['artist_name']);
		$cDescription = mysql_real_escape_string($data['description']);
		$cYearFounded = (int)($data['year_founded']);
		$sql = "INSERT INTO artists (name, description, founded_in) VALUES ('$cName', '$cDescription', $cYearFounded)";
	
		mysql_query($sql) or die($sql . "-->" . mysql_error());
		
		// Todo: do validation.
		return array();
	}

	function updateFromData($data) {
		$id = (int)($data['artist_id']);
		$cName = mysql_real_escape_string($data['artist_name']);
		$cDescription = mysql_real_escape_string($data['description']);
		$cYearFounded = (int)($data['year_founded']);
		$sql = "UPDATE artists SET name='$cName', description='$cDescription', founded_in='$cYearFounded' WHERE id=$id LIMIT 1";
		
		mysql_query($sql) or die($sql . "-->" . mysql_error());
		
		// Todo: do validation.
		return array();
	}
}



?>
