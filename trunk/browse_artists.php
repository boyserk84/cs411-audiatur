<?php

require_once('includes/global.php');
require_once('includes/page.php');
require_once('models/artist.php');
require_once('models/album.php');

class BrowseArtistsPage extends Page {
	var $title = "Browse Artists";

	function content() {	
		if (array_key_exists('keyword', $_GET)) {
			$artists = Artist::getAll($_GET['keyword']);
		} else {
			$artists = Artist::getAll();
		}
		
		if (array_key_exists('like_artist', $_GET) || array_key_exists('love_artist', $_GET)
		|| array_key_exists('unlike_artist', $_GET) || array_key_exists('unlove_artist', $_GET))
		{
		
			$degree = 0;
			if (array_key_exists('like_artist', $_GET)) $degree = 1;
			if (array_key_exists('love_artist', $_GET)) $degree = 2;
		
			if (!array_key_exists('username', $_SESSION))
			{
				Page::printError("You are not logged in. The requested action cannot be done.");
				return;
			}
			if (!isset($_GET['artist_id']))
			{
				Page::printError("One or more required identifiers is missing. You may have reached this page in error.");
				return;
			}		
			
			
			$artist_id = strip_tags($_GET['artist_id']);				
		
			$row = Artist::getArtistById($artist_id);
			if (DEBUG)
			{
				print_r($row);
			}
			if (empty($row))
			{
				Page::printError("The artist you are looking for does not exist - you may have reached this page in error.");
				return;
			}
			$albums = Artist::getAlbumsOfArtist($artist_id);
			
			User::likeArtist($_SESSION['userid'], $artist_id, $degree);
			foreach($albums as $album){
				User::likeAlbum($_SESSION['userid'], $artist_id, $album['album_name'], $degree);
				$songs = $songs = Album::getSongsOnAlbum($album['artist_id'],$album['album_name']);
				foreach($songs as $song){
					User::likeSong($_SESSION['userid'], $artist_id, $album['album_name'], $song['song_name'], $degree);
				}
			}
			
			
		}
		
		if (array_key_exists('username', $_SESSION))
			$artists_like = User::getArtistsLikedBy($_SESSION['userid']);
		else
			$artists_like = $artists;
		?>
	
		<form action='' method='get'>
		Narrow down your results: <input type=text name=keyword value="<?php echo htmlspecialchars(@$_GET['keyword']); ?>"/> <input type=submit value="Go" /> <a href='?'>[Clear]</a>
		</form>
		
		<table class='browse'>
			<tr>				
				<th>Artist Name</th>
				<th>Year Founded</th>
			</tr>

		<?php

		foreach ($artists as $artist) {
			//Check current rating for this artist
			$rating = 0;
			if (array_key_exists('userid', $_SESSION)) {				
				foreach ($artists_like as $artist_like) {
					print_r($artist_like);
					if($artist_like['artist_id'] == $artist['id'])
					{
						$rating = $artist_like['rating'];
					}
				}
			}
			?>
			
			<tr class='row<?php echo $c = ++$c % 2; ?>'>
				<td>
				<a href='view_artist.php?artist_id=<?php echo $artist['id']; ?>'>
				<?php echo $artist['name']; ?></a>
				</td>
				<td>
				<?php echo $artist['founded_in']; ?>
				</td>
				<?php
					if($rating == 0){
					?>
						<td>
						<?php makeButton('artist','like',$artist['id']); ?>
						</td>
						<td>
						<?php makeButton('artist','love',$artist['id']); ?>
						</td>
						<?php
					}
					else
					{
						echo ("<td>");
						showLikeOptionButtons('artist',$rating,$artist['id']);
						echo ("</td>");					
					}
					?>
			</tr>

			<?php
		}


		?>

		</table>

		<?php
	}
}

$b = new BrowseArtistsPage();
$b->render();
