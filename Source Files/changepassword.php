<?php
include 'core/init.php';
protect_page();
include 'include/overall/header.php';
include 'include/overall/headerTitle.php'; ?>

<div class="w3-card-4 w3-margin-top w3-container">

<?php

if (empty($_POST) === false) {
	$required_fields = array('old_password', 'new_password', 'password_again');
	foreach ($_POST as $key => $value) {
// If some value is empty and it's in the $required_fields array
		if (empty($value) && in_array($key, $required_fields) === true) {
			$errors[] = 'Fields marked with an * are required...';
			break 1;
		}
	}
	if (empty($errors) === true) {
		if (md5($_POST['old_password']) === $user_data['password']) {
			if (trim($_POST['new_password']) !== trim($_POST['password_again'])) {
				$errors[] = 'Passwords don\'t match...';
			} else if (strlen($_POST['new_password']) < 6) {
				$errors[] = 'Passwords must be at least 6 characters';
			}
			if ($user_data['password'] === $_POST['new_password']) {
				$errors[] = 'Your new password is same as the old one...';
			}
		} else {
			$errors[] = 'Sorry, your current password is incorrect';
		}
	}
}
?>

<h1>Change Password...</h1>
<?php 
if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
	echo 'You\'ve been changed your password successfully..';
} else {
	if (isset($_GET['force']) === true && empty($_GET['force']) === true) { ?>
		<p style="color: orange;">You must change your password now</p><br>
	<?php
	}
	// Display errors
	if (empty($_POST) === false && empty($errors) === false) { ?>
		<h2 class="w3-text-red">Something went wrong...</h2>
		<?php
		echo output_errors($errors);
	} else if (empty($_POST) === false) {
		# Change password
		change_password($connection, $session_user_id, $_POST['new_password']);
		// Redirect
		header('Location: changepassword.php?success');
		// exit
		exit();
	}

	?>
	<form action="" method="post">
		<label class="w3-label w3-xlarge w3-text-dark-grey" for="old-password">Old Password <span class="w3-text-red">*</span></label>
		<input class="w3-input w3-border" type="password" name="old_password" placeholder=" Old Password">
		<label class="w3-label w3-xlarge w3-text-dark-grey" for="new-password">New Password <span class="w3-text-red">*</span></label>
		<input class="w3-input w3-border" type="password" name="new_password" placeholder=" New Password">
		<label class="w3-label w3-xlarge w3-text-dark-grey" for="password">Conform Password <span class="w3-text-red">*</span></label>
		<input class="w3-input w3-border" type="password" name="password_again" placeholder=" Conform Password">
		<button class="w3-btn w3-teal w3-xlarge w3-margin-top">Chnage Password</button><br><br>
	</form>
	<?php 

} ?>

</div>
</div>

<?php include 'include/overall/footer.php'; ?>