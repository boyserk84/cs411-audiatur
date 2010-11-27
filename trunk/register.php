<?php

require_once('includes/global.php');
require_once('includes/page.php');
require_once('models/user.php');


class RegisterPage extends Page 
{
	var $title = "Register with Audiatur";
	
	function content()
	{
		global $loggedIn;
		if ($loggedIn) {
			die("You are already registered!");
		}
	
		if (array_key_exists('username', $_POST)) { 
			$u = User::createUserFromArray($_POST);
			if ($u) {
				echo "Congratulations! You're now registered as <b>{$_POST['username']}</b>. <a href='index.php'>Go back</a>";
				$_SESSION['username'] = $_POST['username'];
				$_SESSION['userid'] = mysql_insert_id();
				return;

			} else {
				echo "<b>Sorry, that username is already taken.</b>";
			}
		}

		?>
		<form action='' method='post'>
		<table>
		<tr>
			<td>Username</td>
			<td><input type=text name='username' value='<?php if (array_key_exists('username', $_POST)) { echo $_POST['username']; } ?>'/></td>
		</tr>
		<tr>
			<td>Email</td>
			<td><input type=text name='email' value='<?php if (array_key_exists('email', $_POST)) { echo $_POST['email']; } ?>'/></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type=password name='password'/></td>
		</tr>
		<tr>
			<td colspan=2 align=center>
				<input type='submit' value='Register'/>
			</td>
		</tr>
		</table>
		</form>

		<?php
	}


}

$p = new RegisterPage();
$p->render();

?>
