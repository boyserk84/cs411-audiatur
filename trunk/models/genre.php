<?php

require_once('includes/model.php');
require_once('includes/database.php');

class Genre extends Model 
{
	function getAllGenres()
	{
		$qry = "SELECT * FROM genres";
		$res = mysql_query($qry);
		$res_array = Database::resultToArray($res);
		if (DEBUG) 
		{
			echo "$qry returned results: <br>";
			print_r($res_array);			
		}
		return $res_array;
	}
	
	function getGenreByGenreName($name)
	{	
		$name = mysql_real_escape_string($name);
		$qry = "SELECT * FROM genres WHERE genre_name=$name";
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