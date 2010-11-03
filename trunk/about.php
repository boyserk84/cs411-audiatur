<?php

require_once('includes/global.php');
require_once('includes/page.php');
require_once('models/song.php');


class AboutPage extends Page 
{
	var $title = "About Audiatur";
	
	function content()
	{
		?>
			<p style="width:700px">Audiatur is a Latin verb meaning 'let it be heard' <i>(that's 3rd person singular present passive subjunctive, by the way). </i>It is a student project created by Robert and Theodore Nubel (possibly the only two CS seniors still taking Latin at UIUC), Nate Kemahava and Benjamin Cheng for CS411.</p>
		<?php
	}


}

$p = new AboutPage();
$p->render();

?>