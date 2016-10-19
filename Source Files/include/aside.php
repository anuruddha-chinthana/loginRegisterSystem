<?php
if (logged_in() == true) {
	include 'widgets/loggedin.php';
} else {
	include 'widgets/login.php';
}
include 'widgets/count_users.php';
?>