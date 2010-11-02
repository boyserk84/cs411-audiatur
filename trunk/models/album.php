<?php

require_once('includes/model.php');
require_once('includes/database.php');

class Album extends Model 
{
	function getAll() {
		$sql = "SELECT artists.name AS artist_name, albums.* FROM albums LEFT JOIN artists ON albums.artist_id=artists.id";
		$qry = mysql_query($sql);
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
	
}



?>
