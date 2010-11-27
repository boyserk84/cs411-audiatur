<?php
// Class to wrap recommendation functionality. For efficiency,
// does not use models.

class RecommendationEngine {
	function getRecommendationsForUser($user_id, $debug=false) {
		$cutoff = 30;

		// First, build a temporary table to determine how relevant
		// our other users are.
		$tablename = "user_relevancy_for_user_{$user_id}";

		$sql = "CREATE TEMPORARY TABLE $tablename ("
			."other_user_id INTEGER, "
			."relevancy_score DECIMAL(10) "
			.")";
		if ($debug) { echo "Temp table query:<br/>$sql<br/><br/>"; }
		mysql_query($sql) or die(mysql_error());

		$sql = "INSERT INTO $tablename SELECT uls2.user_id, LOG(2, COUNT(uls2.song_name))"
			." FROM users_liking_songs uls1 LEFT JOIN users_liking_songs uls2 ON uls1.user_id=$user_id AND uls2.user_id <> $user_id "
			." AND uls1.song_name = uls2.song_name AND uls1.album_name = uls2.album_name AND uls1.artist_id = uls2.artist_id"
			." GROUP BY uls2.user_id";
		if ($debug) { echo "Temp table fill query:<br/>$sql<br/><br/>"; }
		mysql_query($sql) or die(mysql_error());

		if ($debug) { 
			$qry = mysql_query("SELECT * FROM $tablename");
			while ($row = mysql_fetch_assoc($qry)) {
				echo implode(" | ", $row) . "<br/>";
			}
		}

		// Now, use our relevancy table to pick songs this user might like.
		$sql = "SELECT uls.song_name, uls.album_name, uls.artist_id, a.name as artist_name, "
					."SUM(rel.relevancy_score) as score "
				." FROM (users_liking_songs uls LEFT JOIN $tablename rel ON uls.user_id = rel.other_user_id) "
				." LEFT JOIN artists a ON uls.artist_id=a.id"
				." WHERE NOT EXISTS(SELECT 1 FROM users_liking_songs "
						."WHERE song_name=uls.song_name AND artist_id=uls.artist_id AND album_name=uls.album_name AND user_id={$user_id})"
				." GROUP BY uls.song_name, uls.album_name, uls.artist_id, a.name ORDER BY score DESC LIMIT $cutoff";
		if ($debug) { echo "Scoring query:<br/>$sql<br/><br/>"; }

		if ($debug) { 
			$qry = mysql_query($sql) or die(mysql_error());
			while ($row = mysql_fetch_assoc($qry)) {
				echo implode(" | ", $row) . "<br/>";
			}
		}

		// Print out a list of our top $cutoff recommendations.
		$qry = mysql_query($sql) or die(mysql_error());		
		while ($row = mysql_fetch_assoc($qry)) {
			?>
				<a href=''><?php echo cleanSongName($row['song_name']); ?></a> by <a href=''><?php echo $row['artist_name']; ?></a>   <i>(score=<?php echo $row['score']?>)</i><br/>
			<?php
		}
	}


}

?>
