<?php

require_once('includes/model.php');
require_once('includes/database.php');

class Song extends Model 
{
	function getAllSongsFromArtistId($a_id)
	{
		$a_id = mysql_real_escape_string($a_id);
		$qry = "SELECT * FROM songs WHERE artist_id=$a_id";
		$res = mysql_query($qry);
		$res_array = Database::resultToArray($res);
		if (DEBUG) 
		{
			echo "$qry returned results: <br>";
			print_r($res_array);			
		}
		return $res_array;
	}
	
	function getAllSongs()
	{
		$qry = "SELECT * FROM songs LEFT JOIN artists ON songs.artist_id = artists.id LEFT JOIN albums ON artists.id = albums.artist_id";
		$res = mysql_query($qry);
		$res_array = Database::resultToArray($res);
		if (DEBUG) 
		{
			echo "$qry returned results: <br>";
			print_r($res_array);			
			
		}
		return $res_array;
	}
	
	function getSongByNameArtistAndAlbum($name,$artist_id,$album_name)
	{	
		$name = mysql_real_escape_string($name);
		$artist_id = (int)($artist_id);
		$album_name = mysql_real_escape_string($album_name);
		$qry = "SELECT * FROM songs LEFT JOIN artists ON songs.artist_id = artists.id"
				." LEFT JOIN albums ON songs.album_name = albums.album_name AND albums.artist_id=songs.artist_id"
				." WHERE song_name='$name' AND songs.artist_id = $artist_id AND songs.album_name = '$album_name'";
		$res = mysql_query($qry);
		$res_row = Database::resultToRow($res);
		if (DEBUG) 
		{
			echo "$qry returned results: <br>";
			print_r($res_row);
		}
		return $res_row;
	
	}

}



?>