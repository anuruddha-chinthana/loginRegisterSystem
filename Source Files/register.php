<?php
include 'core/init.php';
logged_in_redirect();
include 'include/overall/header.php';
include 'include/overall/headerTitle.php'; ?>

<div class="w3-card-4 w3-margin-top w3-container">

<?php
if (empty($_POST) === false) {
	$required_fields = array('first_name', 'last_name', 'username', 'password', 'password_again', 'email');
	foreach ($_POST as $key => $value) {
// If some value is empty and it's in the $required_fields array
		if (empty($value) && in_array($key, $required_fields) === true) {
			$errors[] = 'Fields marked with an * are required...';
			break 1;
		}
	}
	if (empty($errors) === true) {
		if (user_exists($connection, $_POST['username']) === true) {
			$errors[] = 'Sorry, username \'' . $_POST['username'] . '\' already taken';
		}
		if (preg_match("/\\s/", $_POST['username']) == true) {
			$errors[] = 'Username can not contain any spaces';
		}
		if (strlen($_POST['password']) < 6) {
			$errors[] = 'Password must be at least 6 characters';
		}
		if ($_POST['password'] !== $_POST['password_again']) {
			$errors[] = 'Passwords don\'t match...';
		}
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
			$errors[] = 'Please enter a valid email';
		}
		if (email_exists($connection, $_POST['email']) === true) {
			$errors[] = 'Sorry, email \'' . $_POST['email'] . '\' already in use';
		}
	}
}
?>

<h1>Create an account...</h1>
<?php 
if (isset($_GET['success']) && empty($_GET['success'])) {
	echo '<p class="w3-text-green">You\'ve been registered successfully..<br>Please check your email to activate your account...</p>';
} else {
	// Display errors
	if (empty($_POST) === false && empty($errors) === false) { ?>
		<h2 class="w3-text-red">Something went wrong...</h2>
		<?php
		echo output_errors($errors);
	} else if (empty($_POST) === false) {
		# Register user
		$register_data = array(
			'first_name' => $_POST['first_name'],
			'last_name' => $_POST['last_name'],
			'email' => $_POST['email'],
			'username' => $_POST['username'],
			'password' => $_POST['password'],
			'email_code' => md5($_POST['password'] + microtime())
			);
		register_user($connection, $register_data);
		// Redirect
		header('Location: register.php?success');
		// exit
		exit();
	}

	?>
	<div class="register-form">
		<form action="" method="post">
			<label class="w3-label w3-xlarge w3-text-dark-grey" for="firstname">First Name <span class="w3-text-red">*</span></label>
			<input class="w3-input w3-border" type="text" name="first_name" placeholder=" First Name">
			<label class="w3-label w3-xlarge w3-text-dark-grey" for="lastname">Last Name <span class="w3-text-red">*</span></label>
			<input class="w3-input w3-border" type="text" name="last_name" placeholder=" Last Name">
			<label class="w3-label w3-xlarge w3-text-dark-grey" for="email">Email <span class="w3-text-red">*</span></label>
			<input class="w3-input w3-border" type="text" name="email" placeholder=" Email">
			<label class="w3-label w3-xlarge w3-text-dark-grey" for="username">Username <span class="w3-text-red">*</span></label>
			<input class="w3-input w3-border" type="text" name="username" placeholder=" Username">
			<label class="w3-label w3-xlarge w3-text-dark-grey" for="password">Password <span class="w3-text-red">*</span></label>
			<input class="w3-input w3-border" type="password" name="password" placeholder=" Password">
			<label class="w3-label w3-xlarge w3-text-dark-grey" for="password">Conform Password <span class="w3-text-red">*</span></label>
			<input class="w3-input w3-border" type="password" name="password_again" placeholder=" Conform Password">
			<button class="w3-btn w3-teal w3-xlarge w3-margin-top">Create an account</button><br><br>
		</form>
	</div>
	<?php 

} ?>

</div>
</div>

<?php include 'include/overall/footer.php'; ?>