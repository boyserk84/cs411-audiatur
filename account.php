<?php

require_once('includes/global.php');
require_once('includes/page.php');
require_once('models/song.php');

require_once('includes/recommendation.php');


class AccountPage extends Page 
{
	var $title = "My Account";
	
	function content()
	{
		global $loggedIn;
		if (!$loggedIn) {
			Page::printError("You must be logged in to view this page.");
			return;
		}

		?>
		<h2>Our Recommendations</h2>
		Based on what songs you've liked and loved, we've looked at other users' profiles and have the following recommendations: 
		<div style='padding:20px;'>
		<?php

		RecommendationEngine::getRecommendationsForUser($_SESSION['userid']);

		?>
		</div>
		<?php
	}


}

$p = new AccountPage();
$p->render();

?>
