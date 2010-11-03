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
		$qry = "SELECT * FROM songs LEFT JOIN artists ON songs.artist_id = artists.id LEFT JOIN albums ON songs.album_name = albums.album_name AND songs.artist_id = albums.artist_id";
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

		
	function insertFromPost() {
		Song::insertFromData($_POST);
	}

	function updateFromPost() {
		Song::updateFromData($_POST);
	}

	function insertFromData($data) {
		$cName = mysql_real_escape_string($data['song_name']);
		$cDuration = mysql_real_escape_string($data['duration']);
		$cArtistId = (int)($data['artist_id']);
		$cAlbumName = mysql_real_escape_string($data['album_name']);
		$sql = "INSERT INTO songs (song_name, duration, artist_id, album_name) VALUES ('$cName', '$cDuration', $cArtistId, '$cAlbumName')";
	
		mysql_query($sql) or die($sql . "-->" . mysql_error());
		
		// Todo: do validation.
		return array();
	}

	function updateFromData($data) {
		$cName = mysql_real_escape_string($data['song_name']);
		$cDuration = mysql_real_escape_string($data['duration']);
		$cArtistId = (int)($data['artist_id']);
		$cAlbumName = mysql_real_escape_string($data['album_name']);
		$cOldSongName = mysql_real_escape_string($data['old_name']);
		$sql = "UPDATE songs SET song_name='$cName', duration='$cDuration' WHERE artist_id=$cArtistId AND album_name='$cAlbumName' AND song_name='$cOldSongName' LIMIT 1";
		
		mysql_query($sql) or die($sql . "-->" . mysql_error());
		
		// Todo: do validation.
		return array();
	}
	
}



?>
