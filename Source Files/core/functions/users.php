<?php 
// Upload user profile image
function change_profile_image($con, $user_id, $temp, $ext) {
	$filepath = 'img/profile/' . substr(md5(time()), 0, 9) . "." . $ext;
	move_uploaded_file($temp, $filepath);
	$sql = 'UPDATE users SET profile=\'' . $filepath . '\' WHERE user_id=' . (int)$user_id;
	mysqli_query($con, $sql);
}
// Email all users
function email_users($con, $subject, $body) {
	$sql = "SELECT email, first_name FROM `users` WHERE allow_email=1";
	while (($row = mysqli_fetch_assoc($con, $sql)) != false) {
		email($row['email'], $subject, "Hello " . $row['first_name'] . ",\n\n" . $body);
	}
}
// Recover username and password
function recover($con, $mode, $email) {
	$mode = checkData($con, $mode);
	$email = checkData($con, $email);

	$user_data = user_data($con, user_id_from_email($con, $email), 'user_id', 'first_name', 'username');

	if ($mode == 'username') {
		email($email, 'Recover username', "Hello ". $user_data['first_name'] .",\n\nYour username is : ". $user_data['username'] ."\n\nDAC Creation");
	} else if ($mode == 'password') {
		$generated_password = substr(md5(rand(999, 999999)), 0, 8);
		change_password($con, $user_data['user_id'], $generated_password);
		$sql = "UPDATE users SET password_recovered=1 WHERE user_id=" . $user_data['user_id'];
		mysqli_query($con, $sql) or die(mysqli_error());
		email($email, 'Recover password', "Hello ". $user_data['first_name'] .",\n\nYour new password is : ". $generated_password ."\n\nDAC Creation");
	}
}

// Update user
function update_user($con, $update_data) {
	$update = array();

	foreach ($update_data as $field => $data) {
		$update[] = $field . "='" . $data . "'";
	}

	$sql = "UPDATE users SET " . implode(', ', $update) . " WHERE user_id=" . $_SESSION['user_id'];
	mysqli_query($con, $sql) or die(mysqli_error());
}

// Activate user
function activate($con, $email, $code) {
	$email = checkData($con, $email);
	$code = checkData($con, $code);

	$sql = "SELECT * FROM users WHERE email = '$email' AND email_code = '$code' AND active = 0";

	$result = mysqli_query($con, $sql);

	if (mysqli_num_rows($result) == 1) {
		# Update the user activate status
		$update_sql = "UPDATE users SET active=1 WHERE email = '$email'";
		mysqli_query($con, $update_sql);
		return true;
	} else {
		return false;
	}
}

// Send email
function email($to, $subject, $body){
	mail($to, $subject, $body, 'From: daccreation@gmail.com');
}

// Change password
function change_password($con, $id, $password) {
	$password = md5($password);
	$sql = "UPDATE users SET password='$password', password_recovered=0 WHERE user_id = $id";
	echo $sql;
	mysqli_query($con, $sql);
}

// Register user
function register_user($con, $register_data) {
	/* Something wrong with bellow line
	
	array_walk($register_data, 'array_checkdata');

	*/
	$register_data['password'] = md5($register_data['password']);

	$data = '\'' . implode('\', \'', $register_data) . '\'';
	$fields = implode(', ', array_keys($register_data));

	$sql = "INSERT INTO users ($fields) VALUES ($data)";
	mysqli_query($con, $sql);
	email($register_data['email'], 'Activate your account', "Hello" . $register_data['first_name'] . ",\n\n You need to activate your account using the link bellow\n\nLink - http://http://localhost:8080/login/activate.php?email=" . $register_data['email'] . "&email_code=" . $register_data['email_code'] . "\n\n- DAC Creation -");
}

// Count users
function user_count($con) {
	$query = "SELECT * FROM users WHERE active = 1";
	return mysqli_num_rows(mysqli_query($con, $query));
}

// Getting user data
function user_data($con, $user_id) {
	$data = array();

	$user_id = (int)$user_id;

	$fun_num_arg = func_num_args();
	$fun_get_arg = func_get_args();

	if ($fun_num_arg > 1) {
		unset($fun_get_arg[0], $fun_get_arg[1]);

		$fields = implode(', ', $fun_get_arg);
		$sql = "SELECT $fields FROM users WHERE user_id = $user_id";

		$data = mysqli_fetch_assoc(mysqli_query($con, $sql));
		
		return $data;
	}
}

// Check the user already login
function logged_in() {
	return (isset($_SESSION['user_id'])) ? true : false;
}

// Check the user already exists
function user_exists($con, $uname) {
	$uname = checkData($con, $uname);
	$query = "SELECT user_id FROM users WHERE username = '$uname'";

	if (mysqli_num_rows(mysqli_query($con, $query)) == 1) {
		return true;
	} else {
		return false;
	}
}

// Check the email already exists
function email_exists($con, $email) {
	$email = checkData($con, $email);
	$query = "SELECT user_id FROM users WHERE email = '$email'";

	if (mysqli_num_rows(mysqli_query($con, $query)) == 1) {
		return true;
	} else {
		return false;
	}
}

// Check the user is active
function user_active($con, $uname) {

	$query = "SELECT user_id FROM users WHERE username = '$uname' AND active = 1";

	if (mysqli_num_rows(mysqli_query($con, $query)) == 1) {
		return true;
	} else {
		return false;
	}
}

// Get user id from the username
function user_id_from_username($con, $username) {
	$query = "SELECT user_id FROM users WHERE username = '$username'";
	$result = mysqli_query($con, $query);
	$data = mysqli_fetch_array($result);
	return $data['user_id'];
}

// Get user id from the email
function user_id_from_email($con, $email) {
	$query = "SELECT user_id FROM users WHERE email = '$email'";
	$result = mysqli_query($con, $query);
	$data = mysqli_fetch_array($result);
	return $data['user_id'];
}

// User login
function login($con, $username, $password) {
	$user_id = user_id_from_username($con, $username);
	$password = md5($password);
	$sql = "SELECT user_id FROM users WHERE username = '$username' AND password = '$password'";
	if (mysqli_num_rows(mysqli_query($con, $sql)) === 1) {
		return $user_id;
	} else {
		return false;
	}
}

?>