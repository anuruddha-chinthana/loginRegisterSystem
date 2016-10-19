<?php
include 'core/init.php';

if (empty($_POST) === false) {
	$required_fields = array('first_name', 'last_name', 'username', 'password', 'password_again', 'email');
	foreach ($_POST as $key => $value) {
// If some value is empty and it's in the $required_fields array
		if (empty($value) && in_array($key, $required_fields)) {
			$errors[] = 'Fields marked with an * are required...';
			break 1;
		}
	}
}
if (empty($errors) === true) {
	if (user_exists($connection, $_POST['username']) === true) {
		$errors[] = 'Sorry, username \'' . $_POST['username'] . '\' already taken';
	}
}

?>