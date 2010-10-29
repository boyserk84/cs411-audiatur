<?php

require_once('include/model.php');
require_once('include/database.php');

class Album extends Model 
{
	function getAll() {
		$sql = "SELECT * FROM albums";
		$qry = mysql_query($sql);
		return Database::resultToArray($qry);
	}

	function getByNameAndArtist($album_name, $artist_id) {
		$cArtistId = (int)$artist_id;
		$cAlbumName = mysql_real_escape_string($album_name);
		$sql = "SELECT * FROM albums WHERE album_name='$cAlbumName' AND artist_id=$artist_id";
		$qry = mysql_query($sql);
		return Database::resultToRow($qry);
	}

	function getSongsOnAlbum($artist_id, $album_name) {
		$cArtistId = (int)$artist_id;
		$cAlbumName = mysql_real_escape_string($album_name);
		$sql = "SELECT * FROM songs s LEFT JOIN albums a ON s.album_name = a.album_name AND s.artist_id = a.artist_id "
				." LEFT JOIN artists ar ON ar.artist_id = s.artist_id"
			." WHERE s.artist_id=$artist_id AND s.album_name='$cAlbumName'";
		$qry = mysql_query($sql);
		return Database::resultToArray($qry);
	}
	
}



?>
