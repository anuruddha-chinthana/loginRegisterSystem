<?php 
function has_access($con, $user_id, $type) {
	$user_id = (int)$user_id;
	$type = (int)$type;
	$sql = "SELECT * FROM users WHERE user_id=$user_id AND type=$type";
	return (mysqli_num_rows(mysqli_query($con, $sql)) == 1) ? true : false;
}
function protect_page() {
	if (logged_in() === false) {
		header('Location: protected.php');
		exit();
	}
}
function protect_admin($con) {
	global $user_data;
	if (has_access($con, $user_data['user_id'], 1) === false) {
		header('Location: index.php');
		exit();
	}
}

function logged_in_redirect() {
	if (logged_in() === true) {
		header('Location: index.php');
		exit();
	}
}

function checkData($con, $data) {
	return mysqli_real_escape_string($con, $data);
}

function array_checkdata($con, &$item) {
	$item = mysqli_real_escape_string($con, $item);
}

function output_errors($err) {
	return '<ul class="w3-text-red"><li>' . implode('</li><li>', $err) . '</li></ul>';
}

?>