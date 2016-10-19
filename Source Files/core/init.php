<?php 
	# Start the sesson
session_start();
	# Disable the default php error report
#error_reporting(0);
require 'database/connect.php';
require 'functions/general.php';
require 'functions/users.php';

$current_file = explode('/', $_SERVER['SCRIPT_NAME']);
$current_file = end($current_file);

if (logged_in() === true) {
	$session_user_id = $_SESSION['user_id'];

	$user_data = user_data($connection, $session_user_id, 'user_id', 'username', 'password', 'first_name', 'last_name', 'email', 'password_recovered', 'type', 'allow_email', 'profile');
	/* No need for logic bacause we're checking user active state when a user login to the system, there is no way to login to the system if user not active there account...
		if (user_active($connection, $user_data['username']) == false) {
			header('Location: logout.php');
			exit();
		}*/
	if ($current_file !== 'logout.php' && $current_file !== 'changepassword.php' && $user_data['password_recovered'] == 1) {
		header('Location: changepassword.php?force');
		exit();
	}
}
	
$errors = array();
?>