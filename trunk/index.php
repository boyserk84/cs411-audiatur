<?php

require 'includes/global.php';
require 'includes/page.php';


class IndexPage extends Page {
	function content() {
		?>
			<h2>Welcome to Audiatur!</h2>
			<p>Audiatur is a music database, containing thousands of songs, artists, and albums for you to browse through. In addition, it has a unique recommendation engine which can, after you've selected some songs you like, recommend other songs and artists you might like.</p>

		<?php

	}

}

$page = new IndexPage();
$page->render();
