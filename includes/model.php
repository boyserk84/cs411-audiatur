<?php
/**
 * Template for a Model (a class which wraps around something
 * in the database).
 *
 * There is no real reason right now to extend Model, but we
 * might feasibly add helper methods so it can't hurt.
 */

class Model {
	// Example of a function we might have:
	function getAll($limit = 30) {
		$result = mysql_query("SELECT * FROM mytable LIMIT $limit;"); // Is $limit safe to inject?
		$objects = Database::resultToArray($result);
		
		/*
		
			Objects is now something like:
			
			[ 0  =>	  [ 'id' => 1, 'name' => 'myobj', 'misc' => 'something' ] ,
			  1  =>   [ 'id' => 2, 'name' => 'other', 'misc' => 'thing'     ] ,
			  etc.
			]
			
			That is, each row is a row from the database that our query returned.	 	
		*/
		
		foreach ($objects as $object) {
			echo $object['id'] . ", " . $object['name'] . "<br/>";
		}
	}

}