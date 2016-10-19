<?php
include 'core/init.php';
logged_in_redirect();

if (empty($_POST) === false) {
	$username = checkData($connection, $_POST['username']);
	$password = checkData($connection, $_POST['password']);
	if (empty($username) === true || empty($password) === true) {
		$errors[] = "Please enter the username and the password...";
	} else if (user_exists($connection, $username) === false) {
		$errors[] = "Please enter a correct username";
	} else if (user_active($connection, $username) === false) {
		$errors[] = "Please Check your email and activate your account...";
	} else {
		$login = (int)login($connection, $username, $password);
		if ($login == false) {
			$errors[] = "Invalied username/ password...";
		} else {
			// Set user session
			$_SESSION['user_id'] = $login;
			// Redirect to user home
			header('Location: index.php');
			exit();
		}
	}
} else {
	$errors[] = "No data recived";
}

include 'include/overall/header.php';
include 'include/overall/headerTitle.php'; ?>

<div class="w3-card-4 w3-margin-top w3-container">

<?php
if (empty($errors) === false) { ?>
	<h2 class="w3-text-red">Something went wrong...</h2>
	<?php
	echo output_errors($errors);
} ?>

</div>
</div>

<?php
include 'include/overall/footer.php';
?>