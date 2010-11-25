<?php

require_once('includes/global.php');
require_once('includes/page.php');
require_once('models/genre.php');

class BrowseGenresPage extends Page {

	var $title = "Browse Genres";
	function content() {
		// Todo: add search parameters & pagination
		$genres = Genre::getAll();
		
		if (array_key_exists('like_genre', $_GET))
		{
			if (!array_key_exists('username', $_SESSION))
			{
				Page::printError("You are not logged in. The requested action cannot be done.");
				return;
			}
			if (!isset($_GET['name']))
			{
				Page::printError("One or more required identifiers is missing. You may have reached this page in error.");
				return;
			}	
			
			$name = strip_tags($_GET['name']);
			
			$row = Genre::getGenreByGenreName($name);
			
			if (empty($row))
			{
				Page::printError("The genre you are looking for does not exist - you may have reached this page in error.");
				return;
			}
			if(array_key_exists('like_genre', $_GET))
				User::likeGenre($_SESSION['userid'], $name);
		}
		
		if (array_key_exists('username', $_SESSION))
			$genres_like = User::getGenresLikedBy($_SESSION['userid']);
		else
			$genres_like = $genres;
		?>
	
		<table>
			<tr>
				<th>Genre Name</th>
			</tr>

		<?php

		foreach ($genres as $genre) {
			$liked = false;
			foreach ($genres_like as $genre_like) {
				if($genre_like['genre_name'] == $genre['name'])
					$liked = true;
				}
			?>
			
			<tr>
				<td><?php echo $genre['name'];?></td>
				<?php
					if(!$liked){
					?>
				<td>
				<a href='?like_genre&name=<?php echo $genre['name']; ?>'>Like</a>
				</td>
				<?php
					}
					else
					{
					?>
				<td>
				Liked
				</td>
				<?php
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

$b = new BrowseGenresPage();
$b->render();
