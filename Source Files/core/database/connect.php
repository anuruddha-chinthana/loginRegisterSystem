<?php

// Connect to the server
$connection = mysqli_connect('localhost', 'root', '', 'login');

// Check the connection
if (mysqli_connect_errno()) {
	echo "Faild to connect to Database : " . mysqli_connect_errno();
}

?>