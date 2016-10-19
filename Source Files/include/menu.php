<!-- Navigation goes here -->
<ul class="w3-navbar w3-large w3-green w3-left-align w3-xlarge">
	<li class="w3-hide-medium w3-hide-large w3-green w3-opennav w3-left">
		<a href="javascript:void(0);" onclick="navigationFunction()">☰ Menu</a>
	</li>
	<li class="w3-hide-small"><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
	<li class="w3-hide-small"><a href="downloads.php"><i class="fa fa-download" aria-hidden="true"></i> Downloads</a></li>
	<li class="w3-hide-small"><a href="form.php"><i class="fa fa-comments" aria-hidden="true"></i> Form</a></li>
	<li class="w3-hide-small"><a href="contact.php"><i class="fa fa-phone" aria-hidden="true"></i> Contact</a></li>
</ul>
<div id="smallNav" class="w3-hide w3-hide-large w3-hide-medium">
	<ul class="w3-navbar w3-left-align w3-large w3-green w3-xlarge">
		<li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
		<li><a href="downloads.php"><i class="fa fa-download" aria-hidden="true"></i> Downloads</a></li>
		<li><a href="form.php"><i class="fa fa-comments" aria-hidden="true"></i> Form</a></li>
		<li><a href="contact.php"><i class="fa fa-phone" aria-hidden="true"></i> Contact</a></li>
	</ul>
</div>
<script>
	function navigationFunction() {
		var x = document.getElementById("smallNav");
		if (x.className.indexOf("w3-show") == -1) {
			x.className += " w3-show";
		} else {
			x.className = x.className.replace(" w3-show", "");
		}
	}
</script>