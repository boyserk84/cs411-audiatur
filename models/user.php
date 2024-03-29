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
		$cPasswordHash = md5($password);
		$sql = "SELECT * FROM users WHERE user_name='$cUsername' AND password='$cPasswordHash'";

		$qry = mysql_query($sql);

		// If a record was returned, return it. Otherwise, return false to indicate auth failure.
		if ($res = mysql_fetch_assoc($qry)) {
			return $res;
		} else {
			return false;
		}
	}	

	function createUserFromArray($data) {
		$cUsername = mysql_real_escape_string($data['username']);
		$cPassword = md5($data['password']);
		$cEmail = mysql_real_escape_string($data['email']);

		$sql = "INSERT INTO users (user_name, email, password) VALUES ('$cUsername', '$cEmail', '$cPassword')";
		$qry = mysql_query($sql);

		return User::getUserByInformation($data['username'], $data['password']);
	}	

	function getArtistsLikedBy($user_id) {
		$cUserId = (int)$user_id;
		$sql = "SELECT * FROM users_liking_artists WHERE user_id=$cUserId";
		$qry = mysql_query($sql);
		return Database::resultToArray($qry);
	}

	function getAlbumsLikedBy($user_id) {
		$cUserId = (int)$user_id;
		$sql = "SELECT * FROM users_liking_albums ua LEFT JOIN albums a ON ua.album_name=a.album_name AND ua.artist_id=a.artist_id
			 LEFT JOIN artists ar ON ar.id = a.artist_id
			 WHERE user_id=$cUserId";
		$qry = mysql_query($sql);
		return Database::resultToArray($qry);
	}

	function getSongsLikedBy($user_id) {
		$cUserId = (int)$user_id;
		$sql = "SELECT * FROM users_liking_songs us
			 LEFT JOIN songs s 
				 ON us.song_name=s.song_name AND us.album_name = s.album_name AND us.artist_id = s.artist_id 
			 LEFT JOIN albums a 
				 ON a.album_name = us.album_name AND a.artist_id=us.artist_id 
			 LEFT JOIN artists ar 
				 ON ar.id=a.artist_id 
			 WHERE user_id=$cUserId";
		$qry = mysql_query($sql);
		return Database::resultToArray($qry);
	}

	function getGenresLikedBy($user_id) {
		$cUserId = (int)$user_id;
		$sql = "SELECT * FROM users_liking_genres ug LEFT JOIN genres g ON ug.genre_name=g.name WHERE user_id=$cUserId";
		$qry = mysql_query($sql);
		return Database::resultToArray($qry);

	}

	function likeGenre($user_id, $name) {
		$cUserId = (int)$user_id;
		$cName = mysql_real_escape_string($name);
		$cRating = (int)$rating;
		$sql = "INSERT INTO users_liking_genres (user_id, genre_name) VALUES ($cUserId, '$cName')";
		return mysql_query($sql);
	}

	function likeArtist($user_id, $artist_id, $rating) {
		$cUserId = (int)$user_id;
		$cArtistID = (int)$artist_id;
		$cRating = (int)$rating;
		
		$whereclause = "WHERE user_id = $cUserId AND artist_id = $cArtistID";
			
		$sql = " INSERT INTO users_liking_artists (user_id, artist_id, rating) VALUES ($cUserId, $cArtistID, $cRating)";
		$sql .= " ON DUPLICATE KEY ";
		$sql .= " UPDATE  rating = $cRating";
		
		return mysql_query($sql);
	}

	function likeAlbum($user_id, $artist_id, $album_name, $rating) {
		$cUserId = (int)$user_id;
		$cArtistID = (int)$artist_id;
		$cAlbumName = mysql_real_escape_string($album_name);
		$cRating = (int)$rating;
		
		$whereclause = "WHERE user_id = $cUserId AND cArtistID = $cArtistID AND album_name = '$cAlbumName'";
	
		$sql = " INSERT INTO users_liking_albums (user_id, artist_id, album_name, rating) VALUES ($cUserId, $cArtistID, '$cAlbumName', $cRating)";	
		$sql .= " ON DUPLICATE KEY ";
		$sql .= " UPDATE rating = $cRating";
	
			
		return mysql_query($sql);
	}

	function likeSong($user_id ,$artist_id, $album_name, $song_name, $rating) {
		$cUserId = (int)$user_id;
		$cArtistID = (int)$artist_id;
		$cAlbumName = mysql_real_escape_string($album_name);
		$cSongName = mysql_real_escape_string($song_name);
		$cRating = (int)$rating;
		
		$whereclause = "WHERE user_id = $cUserId AND cArtistID = $cArtistID AND album_name = '$cAlbumName' AND song_name = '$cSongName'";

		$sql = " INSERT INTO users_liking_songs (user_id ,artist_id, album_name, song_name, rating) VALUES ($cUserId ,$cArtistID, '$cAlbumName', '$cSongName', $cRating)";
		$sql .= "ON DUPLICATE KEY UPDATE rating = $cRating";

		return mysql_query($sql);
	}

}
