<?php
include 'core/init.php';
protect_page();
include 'include/overall/header.php';
include 'include/overall/headerTitle.php'; ?>

<div class="w3-card-4 w3-margin-top w3-container">

<?php
if (empty($_POST) === false) {
	$required_fields = array('first_name', 'last_name', 'email');
	foreach ($_POST as $key => $value) {
// If some value is empty and it's in the $required_fields array
		if (empty($value) && in_array($key, $required_fields) === true) {
			$errors[] = 'Fields marked with an * are required...';
			break 1;
		}
	}
	if (empty($errors) === true) {
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
			$errors[] = 'Please enter a valid email';
		} else if (email_exists($connection, $_POST['email']) === true && $user_data['email'] !== $_POST['email']) {
			$errors[] = 'Sorry, email \'' . $_POST['email'] . '\' already in use';
		}
	}
}
?>

<h1>Update Data...</h1>
<?php 
if (isset($_GET['success']) && empty($_GET['success'])) {
	echo '<p class="w3-text-green">You\'ve been updated your data successfully..</p>';
} else {
	// Display errors
	if (empty($_POST) === false && empty($errors) === false) { ?>
		<h3 class="error">Something went wrong...</h3>
		<?php
		echo output_errors($errors);
	} else if (empty($_POST) === false) {
		$allow_email = ($_POST['allow_email'] == 'on') ? 1 : 0;
		$update_data = array(
			'first_name' => $_POST['first_name'],
			'last_name' => $_POST['last_name'],
			'email' => $_POST['email'],
			'allow_email' => $allow_email
		);
		update_user($connection, $update_data);
		// Redirect
		header('Location: settings.php?success');
		// exit
		exit();
	}

	?>

		<form action="" method="post">
			<label class="w3-label w3-xlarge w3-text-dark-grey" for="first_name">First Name <span class="w3-text-red">*</span></label>
			<input class="w3-input w3-border" type="text" name="first_name" value="<?php echo $user_data['first_name']?>">
			<label class="w3-label w3-xlarge w3-text-dark-grey" for="last_name">Last Name <span class="w3-text-red">*</span></label>
			<input class="w3-input w3-border" type="text" name="last_name" value="<?php echo $user_data['last_name']?>">
			<label class="w3-label w3-xlarge w3-text-dark-grey" for="email">Email <span class="w3-text-red">*</span></label>
			<input class="w3-input w3-border" type="text" name="email" value="<?php echo $user_data['email']?>"><br>

			<input class="w3-check" type="checkbox" name="allow_email" <?php if ($user_data['allow_email'] == 1) { echo 'checked="checked"';} ?>>
			<label class="w3-validate w3-text-dark-grey">Would you like to receive emails from us..?</label><br>

			<button class="w3-btn w3-teal w3-xlarge w3-margin-top">Update</button><br><br>
		</form>

	<?php 

}

?>
</div>

</div>
<?php include 'include/overall/footer.php'; ?>