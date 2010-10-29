<?php

require_once 'includes/model.php';
require_once 'includes/database.php';

class User extends Model {
	function getAll() {
		$sql = "SELECT * FROM users";
		$qry = mysql_query($sql);
		return Database::resultToArray($qry);		
	}

	function getUserByInformation($username, $password) {
		$cUsername = mysql_real_escape_string($username);
		$cPasswordHash = md5($username);
		$sql = "SELECT * FROM users WHERE username='$cUsername' AND password='$cPasswordHash'";
		$qry = mysql_query($sql);

		// If a record was returned, return it. Otherwise, return false to indicate auth failure.
		if ($res = mysql_fetch_assoc($qry)) {
			return $res;
		} else {
			return false;
		}
	}	


	function getArtistsLikedBy($user_id) {
		$cUserId = (int)$user_id;
		$sql = "SELECT * FROM users_liking_artists WHERE user_id=$cUserId";
		$qry = mysql_query($sql);
		return Database::resultToArray($qry);
	}

	function getAlbumsLikedBy($user_id) {
		$cUserId = (int)$user_id;
		$sql = "SELECT * FROM users_liking_albums ua LEFT JOIN albums a ON ua.album_name=a.album_name AND ua.artist_id=a.artist_id"
			." LEFT JOIN artists ar ON ar.artist_id = a.artist_id"
			." WHERE user_id=$cUserId";
		$qry = mysql_query($sql);
		return Database::resultToArray($qry);
	}

	function getSongsLikedBy($user_id) {
		$cUserId = (int)$user_id;
		$sql = "SELECT * FROM users_liking_songs us"
			." LEFT JOIN songs s "
				." ON us.song_name=s.song_name AND us.album_name = s.album_name AND us.artist_id = s.artist_id "
			." LEFT JOIN albums a "
				." ON a.album_name = us.album_name AND a.artist_id=us.artist_id "
			." LEFT JOIN artists ar "
				." ON ar.album_name = us.album_name AND ar.artist_id=a.artist_id "
			." WHERE user_id=$cUserId";
		$qry = mysql_query($sql);
		return Database::resultToArray($qry);
	}

	function getGenresLikedBy($user_id) {
		$cUserId = (int)$user_id;
		$sql = "SELECT * FROM users_liking_genres ug LEFT JOIN genres g ON ug.genre_id=g.genre_id WHERE user_id=$cUserId";
		$qry = mysql_query($sql);
		return Database::resultToArray($qry);

	}

	function likeGenre($user_id, $genre_id) {
		$cUserId = (int)$user_id;
		$cGenreID = (int)$genre_id;
		$sql = "INSERT INTO users_liking_genres ug (user_id, genre_id) VALUES ($cUserId, $cGenreId)";
		return mysql_query($sql);
	}

	function likeArtist($user_id, $artist_id) {
		$cUserId = (int)$user_id;
		$cArtistID = (int)$artist_id;
		$sql = "INSERT INTO users_liking_artists ua (user_id, artist_id) VALUES ($cUserId, $cArtistId)";
		return mysql_query($sql);
	}

	function likeAlbum($user_id, $artist_id, $album_name) {
		$cUserId = (int)$user_id;
		$cArtistID = (int)$artist_id;
		$cAlbumName = mysql_real_escape_string($album_name);
		$sql = "INSERT INTO users_liking_albums ua (user_id, artist_id, album_name) VALUES ($cUserId, $cArtistId, '$cAlbumName')";
		return mysql_query($sql);
	}

	function likeSong($user_id, $artist_id, $album_name, $song_name) {
		$cUserId = (int)$user_id;
		$cArtistID = (int)$artist_id;
		$cAlbumName = mysql_real_escape_string($album_name);
		$cSongName = mysql_real_escape_string($song_name);
		$sql = "INSERT INTO users_liking_songs us (user_id, artist_id, album_name, song_name) VALUES ($cUserId, $cArtistId, '$cAlbumName', '$cSongName')";
		return mysql_query($sql);
	}


}
