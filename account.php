<?php

require_once('includes/global.php');
require_once('includes/page.php');
require_once('models/song.php');


class AccountPage extends Page 
{
	var $title = "My Account";
	
	function content()
	{
		echo("Sorry, this page is still under construction.");	
	}


}

$p = new AccountPage();
$p->render();

?>