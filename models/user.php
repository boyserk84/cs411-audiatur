<?php

require_once 'includes/model.php'
require_once 'includes/database.php'

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
		$sql = "SELECT * FROM users_liking_songs WHERE user_id=$cUserId";
		$qry = mysql_query($sql);
		return Database::resultToArray($qry);
}
