<?php

require_once('includes/model.php');
require_once('includes/database.php');

class Album extends Model 
{
	function getAll($keyword='', $start=0, $count=40) {
		$sql = "SELECT artists.name AS artist_name, albums.* FROM albums LEFT JOIN artists ON albums.artist_id=artists.id"
			. ($keyword = '' ? '' :  ' WHERE albums.album_name LIKE "%' . mysql_real_escape_string($keyword) . '%"')
			. " LIMIT $start, $count";
		$qry = mysql_query($sql) or die(mysql_error());
		return Database::resultToArray($qry);
	}

	function getAllForArtist($artist_id) {
		$cArtistId = (int)$artist_id;
		$sql = "SELECT artists.name AS artist_name, albums.* FROM albums LEFT JOIN artists ON albums.artist_id=artists.id WHERE artist_id=$cArtistId";
		$qry = mysql_query($sql);
		return Database::resultToArray($qry);
	}	

	function getByNameAndArtist($album_name, $artist_id) {
		$cArtistId = (int)$artist_id;
		$cAlbumName = mysql_real_escape_string($album_name);
		$sql = "SELECT * FROM albums LEFT JOIN artists ON albums.artist_id = artists.id WHERE album_name='$cAlbumName' AND artist_id=$artist_id";
		$qry = mysql_query($sql);
		return Database::resultToRow($qry);
	}

	function getSongsOnAlbum($artist_id, $album_name) {
		$cArtistId = (int)$artist_id;
		$cAlbumName = mysql_real_escape_string($album_name);
		$sql = "SELECT * FROM songs s LEFT JOIN albums a ON s.album_name = a.album_name AND s.artist_id = a.artist_id "
				." LEFT JOIN artists ar ON ar.id = s.artist_id"
			." WHERE s.artist_id=$artist_id AND s.album_name='$cAlbumName'";
		$qry = mysql_query($sql);
		
		return Database::resultToArray($qry);
	}
	
		function insertFromPost() {
		Album::insertFromData($_POST);
	}

	function updateFromPost() {
	//	Album::updateFromData($_POST);
	}

	function insertFromData($data) {
		$cName = mysql_real_escape_string($data['album_name']);
		$cDate = mysql_real_escape_string($data['release_date']);
		$cArtistId = (int)($data['artist_id']);

		$sql = "INSERT INTO albums (album_name, release_date, artist_id) VALUES ('$cName', '$cDate', $cArtistId)";

		mysql_query($sql) or die($sql . "-->" . mysql_error());
		
		// Todo: do validation.
		return array();
	}

	function updateFromData($data) {
	/*
		$cName = mysql_real_escape_string($data['song_name']);
		$cDuration = mysql_real_escape_string($data['duration']);
		$cArtistId = (int)($data['artist_id']);
		$cAlbumName = mysql_real_escape_string($data['album_name']);
		$cOldSongName = mysql_real_escape_string($data['old_name']);
		$sql = "UPDATE songs SET song_name='$cName', duration='$cDuration' WHERE artist_id=$cArtistId AND album_name='$cAlbumName' AND song_name='$cOldSongName' LIMIT 1";
		
		mysql_query($sql) or die($sql . "-->" . mysql_error());
		
		// Todo: do validation.
		return array();
		*/
	}


}



?>
