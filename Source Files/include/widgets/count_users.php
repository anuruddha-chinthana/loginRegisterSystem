	<div class="w3-card-4 w3-margin-top">
		<div class="w3-container w3-teal">
			<h2>Users</h2>
		</div>
		<div class="w3-large w3-padding">
			<?php 
				$user_accounts = user_count($connection);
				$suffix = ($user_accounts != 1) ? 's' : '';
			?>
			<p>We're currently have <?php echo $user_accounts; ?> user<?php echo $suffix; ?>..</p>
		</div>
	</div>

</div>