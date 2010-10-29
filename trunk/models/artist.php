<?php

require_once('include/model.php');
require_once('include/database.php');

class Artist extends Model 
{
	function getAllArtists()
	{
		$qry = "SELECT * FROM artists";
		$res = mysql_query($qry);
		$res_array = Database::resultToArray($res);
		if (DEBUG) 
		{
			echo "$qry  returned results: <br>";
			print_r($res_array);			
		}
		return $res_array;
	}
	
	function getGenresOfArtist($id)
	{
		$id = mysql_real_escape_string($id);
		$qry = "SELECT * FROM genres LEFT JOIN artists_playing_genres 
				ON genres.genre_name = artists_playing_genres.genre_name
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
		return $res_array;
	
	}

}



?>