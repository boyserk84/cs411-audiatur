<?php
/* Helper methods to create forms. */

function start_form($action) {
	echo "<form action='$action' method='post'>";
	echo "<table class='genericForm'>";
}

function text_field($label, $name, $val=false) {
	if ($val === false) {
		// Auto-fill from request?
		if (array_key_exists($name, $_REQUEST)) {
			$val = $_REQUEST[$name];
		}
	}
	echo "<tr><td>$label</td>";
	echo "<td><input type=text name='$name' value='$val'/></td></tr>";
}

function hidden_field($name, $val) {
	echo "<input type=hidden name='$name' value='$val'/>";
}

function submit_button($label) {
	echo "<tr><td colspan=2 align=center><input type=submit value='$label'></td></tr>";
}

function close_form() {
	echo "</table>";
	echo "</form>";
}
