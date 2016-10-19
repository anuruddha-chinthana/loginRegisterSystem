<div class="w3-third">

	<div class="w3-card-4 w3-margin-top">
		<div class="w3-container w3-green">
			<h2>Login / Register</h2>
		</div>
		<form action="login.php" method="post" class="w3-container w3-padding">
			<label class="w3-label w3-xlarge w3-text-dark-grey" for="username">Username</label>
			<input class="w3-input w3-border" type="text" name="username" placeholder=" Username">
			<label class="w3-label w3-xlarge w3-text-dark-grey" for="Password">Password</label>
			<input class="w3-input w3-border" type="password" name="password" placeholder=" Password">
			<button class="w3-btn w3-green w3-xlarge w3-margin-top">Login</button><br>
			<p class="w3-large"><a href="register.php">Create an account</a></p>
			<p class="w3-large">Forgotten your <a href="recover.php?mode=password">password</a> or <a href="recover.php?mode=username">username</a>..?</p>
		</form>
	</div>
