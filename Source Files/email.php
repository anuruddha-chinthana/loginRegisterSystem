<?php include 'core/init.php';
protect_page();
protect_admin($connection);
include 'include/overall/header.php';
include 'include/overall/headerTitle.php'; ?>

<div class="w3-card-4 w3-margin-top w3-container">

<h1>Email all users</h1>

<?php 

if (isset($_GET['success']) == true && empty($_GET['success']) == true) {
	echo '<p class="w3-text-green">Message has been sent...</p><br>';
} else {
	if (empty($_POST) == false) {
		if (empty($_POST['subject']) == true) {
			$errors[] = "Subject is required..!";
		}
		if (empty($_POST['body']) == true) {
			$errors[] = "Body is required..!";
		}
		if (empty($errors) == false) {
			echo output_errors($errors);
		} else {
			email_users($connection, $_POST['subject'], $_POST['body']);
			header('Location: email.php?success');
			exit();
		}
	}

	 ?>

	<form action="" method="post">
		<label class="w3-label w3-xlarge w3-text-dark-grey" for="subject">Subject</label>
		<input class="w3-input w3-border" type="text" name="subject" placeholder="Subject">
		<label class="w3-label w3-xlarge w3-text-dark-grey" for="body">Body</label>
		<textarea class="w3-input w3-border" name="body" cols="30" rows="10" placeholder="Body"></textarea>
		<button class="w3-btn w3-teal w3-xlarge w3-margin-top">Send</button><br><br>
	</form>

<?php } ?>

</div>

</div>

<?php include 'include/overall/footer.php'; ?>