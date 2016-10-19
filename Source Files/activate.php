<?php
include 'core/init.php';
logged_in_redirect();
include 'include/overall/header.php';
include 'include/overall/headerTitle.php'; ?>

<div class="w3-card-4 w3-margin-top w3-container">

<?php
if (isset($_GET['success']) == true && empty($_GET['success']) == true) { ?>
	<h1>Thank you, we activated your account...</h1>
	<p>You are free to login...</p>
	<?php
} else if (isset($_GET['email'], $_GET['email_code']) == true) {
	$email = trim($_GET['email']);
	$code = trim($_GET['email_code']);

	if (email_exists($connection, $email) == false) {
		$errors[] = 'Something went wrong, we could not find the email address';
	} elseif (activate($connection, $email, $code) == false) {
		$errors[] = 'Something went wrong with the activation process...';
	}
	// Display errors
	if (empty($errors) == false) { ?>

		<h1>Something went wrong...</h1>

		<?php
		echo output_errors($errors);
	} else {
		header('Location: activate.php?success');
		exit();
	}
} else {
	header('Location: index.php');
	exit();
} ?>

</div>
</div>

<?php include 'include/overall/footer.php'; ?>