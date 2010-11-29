<?php

require_once('includes/global.php');
require_once('includes/page.php');
require_once('models/song.php');

class BrowseSongsPage extends Page {
	
	var $title = "Browse Songs";

	function content() {
		$page = @(int)$_GET['p'];		
		$countPerPage = 40;
		$start = $page * $countPerPage;
		$songs = Song::getAllSongs(@$_GET['keyword'], $start, $countPerPage);
		
		if (array_key_exists('like_song', $_GET) || array_key_exists('love_song', $_GET)
		|| array_key_exists('unlike_song', $_GET) || array_key_exists('unlove_song', $_GET))
		{
			$degree = 0;
			if (array_key_exists('like_song', $_GET)) $degree = 1;
			if (array_key_exists('love_song', $_GET)) $degree = 2;
		
			if (!array_key_exists('username', $_SESSION))
			{
				Page::printError("You are not logged in. The requested action cannot be done.");
				return;
			}
			if (!isset($_GET['song_name']) || !isset($_GET['album_name']) || !isset($_GET['artist_id']))
			{
				Page::printError("One or more required identifiers is missing. You may have reached this page in error.");
				return;
			}	
			
			
			$song_name = strip_tags($_GET['song_name']);
			$album_name = strip_tags($_GET['album_name']);
			$artist_id = strip_tags($_GET['artist_id']);
			
			
			$row = Song::getSongByNameArtistAndAlbum($song_name,$artist_id,$album_name);
			if (empty($row))
			{
				Page::printError("The song you are looking for does not exist - you may have reached this page in error.");
				return;
			}
			
			User::likeSong($_SESSION['userid'], $artist_id, $album_name, $song_name, $degree);
						
		}
		
		if (array_key_exists('username', $_SESSION))
			$songs_like = User::getSongsLikedBy($_SESSION['userid']);
		else
			$songs_like = array();
		
		?>
	
		<form action='' method='get'>
		Narrow down your results: <input type=text name=keyword value="<?php echo htmlspecialchars(@$_GET['keyword']); ?>"/> <input type=submit value="Go" /> <a href='?'>[Clear]</a>
		</form>
	
		<div align="center" id="pagination">
			<?php $p = @$_GET['p'] + 1;  ?>
			<?php if ($p > 0) { ?>
				<a href='?keyword=<?php echo @$_GET['keyword']; ?>&p=0'>First Page</a>
				<a href='?keyword=<?php echo @$_GET['keyword']; ?>&p=<?php echo $p - 2; ?>'>Previous Page</a>  <?php } ?>
			
			Page <?php echo $p; ?> <a href='?keyword=<?php echo @$_GET['keyword']; ?>&p=<?php echo $p; ?>'>Next Page</a>
		</div>
		<table class='browse'>
			<tr>
				<th>Song Name</th>
				<th>Album</th>
				<th>Artist</th>
			</tr>

		<?php

		foreach ($songs as $song) {
			$rating = 0;
			foreach ($songs_like as $song_like) {
				if($song_like['song_name'] == $song['song_name'])
					$rating = $song_like['rating'];
				}
			?>
			
			<tr class='row<?php echo $c = ++$c % 2; ?>'>
				<td>
				<a href='view_song.php?song_name=<?php echo urlencode($song['song_name']); ?>&album_name=<?php echo urlencode($song['album_name']); ?>&artist_id=<?php echo $song['artist_id']; ?>'>
				<?php echo cleanSongName($song['song_name']); ?></a>
				</td>
				<td>
				<a href='view_album.php?album_name=<?php echo urlencode($song['album_name']); ?>&artist_id=<?php echo $song['artist_id']; ?>'>
				<?php echo $song['album_name']; ?></a>
				</td>
				<td>
				<a href='view_artist.php?artist_id=<?php echo urlencode($song['artist_id']); ?>'><?php echo $song['name']; ?></a>				
				</td>
				<?php
				if($rating == 0){
				?>
					<td>
					<?php makeButton('song','like',$song['artist_id'],$song['album_name'],$song['song_name']); ?>
					</td>
					<td>
					<?php makeButton('song','love',$song['artist_id'],$song['album_name'],$song['song_name']); ?>
					</td>
					<?php
				}
				else
				{
					echo ("<td>");
					showLikeOptionButtons('song',$rating,$song['artist_id'],$song['album_name'],$song['song_name']);
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

$b = new BrowseSongsPage();
$b->render();
