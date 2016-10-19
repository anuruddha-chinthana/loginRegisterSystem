<?php
include 'core/init.php';
logged_in_redirect();
include 'include/overall/header.php';
include 'include/overall/headerTitle.php'; ?>

<div class="w3-card-4 w3-margin-top w3-container">

<h1>Recover Username / Password</h1>
<?php 
	if (isset($_GET['success']) === true && empty($_GET['success']) === true) { ?>
		<p class="w3-text-green">We've emailed you...</p>
	<?php 
	} else {
		$mode_allowed = array('username', 'password');
		if (isset($_GET['mode']) === true && in_array($_GET['mode'], $mode_allowed) === true) {
			if (isset($_POST['email']) === true && empty($_POST['email']) === false) {
				if (email_exists($connection, $_POST['email']) === true) {
					recover($connection, $_GET['mode'], $_POST['email']);
					header('Location: recover.php?success');
					exit();
				} else {
					echo "<p class=\"w3-text-red\">Sorry, we couldn\'t find the email address...</p>";
				}
			}
			 ?>

			 <form action="" method="post">
			 	<label class="w3-label w3-xlarge w3-text-dark-grey" for="username">Please enter your email address</label>
			 	<input class="w3-input w3-border" type="text" name="email" placeholder=" Email">
			 	<button class="w3-btn w3-teal w3-xlarge w3-margin-top">Recover</button><br><br>
			 </form>

		<?php
		} else {
			header('Location: index.php');
			exit();
		}
	}
 ?>

 </div>
 </div>

<?php include 'include/overall/footer.php'; ?>