<?php include 'core/init.php';
include 'include/overall/header.php';
include 'include/overall/headerTitle.php'; ?>

<div class="w3-card-4 w3-margin-top w3-container">

<?php
if(isset($_GET['username']) == true && empty($_GET['username']) == false) {
	$username = $_GET['username'];

	if (user_exists($connection, $username)) {
		$user_id = user_id_from_username($connection, $username);

		$profile_data = user_data($connection, $user_id, 'first_name', 'last_name', 'email'); ?>

		<h1><?php echo $profile_data['first_name'] ?>'s Profile</h1>
		<ul class="w3-ul w3-border w3-margin-bottom">
			<li class="w3-padding-8 w3-hover-teal">
				<h3>Name</h3>
				<p><?php echo $profile_data['first_name'] . " " . $profile_data['last_name']?></p>
			</li>
			<li class="w3-padding-8 w3-hover-teal">
				<h3>Contact Information</h3>
				<p><?php echo $profile_data['email'] ?></p>
			</li>
		</ul>

	<?php
	} else {
		echo "<h2 class=\"w3-text-red\">Sorry, User doesn't exists...</h2>";
	}

} else {
	header('Location: index.php');
	exit();
} ?>

</div>
</div>

<?php include 'include/overall/footer.php'; ?>