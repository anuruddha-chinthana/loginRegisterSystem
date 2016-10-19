<div class="w3-third">

	<div class="w3-card-4 w3-margin-top">
		<div class="w3-container w3-teal w3-center">
			<div class="w3-row">
				<div class="w3-col" style="width: 120px;">
					<?php 

					if (isset($_FILES['profile']) == true) {
						if (empty($_FILES['profile']['name']) == true) {
							echo "Please choose a file..";
						} else {
							$allow_format = array('jpg', 'gif', 'png');

							$fileName = $_FILES['profile']['name']; // fileName.ext
							$fileExt = explode('.', $fileName);
							$fileExt = strtolower(end($fileExt));
							$fileTemp = $_FILES['profile']['tmp_name'];

							if (in_array($fileExt, $allow_format)) {
								change_profile_image($connection, $session_user_id, $fileTemp, $fileExt);

								header('Location: ' . $current_file);
								exit();
							} else {
								echo "Incorrect file format\nFile should be ";
								echo implode(', ', $allow_format);
							}
						}
					}

					if (empty($user_data['profile']) == false) {
						echo '<img src="' . $user_data['profile'] . '" alt="' . $user_data['first_name'] . '\'s profile image" class="w3-circle w3-margin" style="width: 100px;">';
					}

					 ?>
					 <form action="" method="post" enctype="multipart/form-data">
					 	<input type="file" name="profile"><input class="w3-left w3-margin-bottom w3-white" type="submit" value="Upload" style="width: 100%; margin-top: 10px;">
					 </form>

				</div>
				<div class="w3-rest">
					<h2 class="w3-padding">Hello<br><?php echo $user_data['first_name']; ?></h2>
				</div>
			</div>
		</div>
		<div class="w3-container">
			<ul class="w3-ul w3-hoverable w3-border w3-margin no-decoration w3-teal w3-large">
				<li><a href="logout.php"><i class="fa fa-power-off" aria-hidden="true"></i>&nbsp; Logout</a></li>
				<li><a href="<?php echo $user_data['username'] ?>"><i class="fa fa-user" aria-hidden="true"></i>&nbsp; Profile</a></li>
				<li><a href="changepassword.php"><i class="fa fa-lock" aria-hidden="true"></i>&nbsp; Change Password</a></li>
				<li><a href="settings.php"><i class="fa fa-cog" aria-hidden="true"></i>&nbsp; Change Settings</a></li>
				<?php 
					if (has_access($connection, $user_data['user_id'], 1) == true) {
						echo '<li><a href="email.php"><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp; Email to All</a></li>';
					}
				 ?>
			</ul>
		</div>
	</div>