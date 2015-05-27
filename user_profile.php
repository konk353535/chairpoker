<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Townsville Community Music Centre</title>
<link href="mainstyle.css" rel="stylesheet" type="text/css">
</head>

<body>

<!-- Logo + Login Form + Text Title -->
<?php include('template/header.php'); ?>
<!-- End of header (Logo/LoginForm/TextTitle) -->

<!-- Nav Bar -->
<?php include('template/inc_nav.php'); ?>

<!-- All Content -->
<div class="allContent">
    <div class="mainContent bgPrimary">
	  <?php
		if(isset($_SESSION['AuthLevel'])){
	  		echo "<h1>Your Membership Profile</h1>";
			if($_SESSION['AuthLevel'] == 3) {
				echo "<p>As a member with Administrator rights, you can make manual adjustments to the site's user submitted notices, artists, and information for upcoming events.</p>\n
				<a href='adminControlPage.php'>Control Page</a>";
			}
			
	    }
        else {
	    	echo "<div class='error_message'>You must log in to access your profile</div>";
	    }
	  ?>
	</div>

	<div class="sideContent bgPrimary">
		<h1>Hello</h1>
		<p>Test</p>
	</div>

</div>
<!-- End of all Content -->

<!-- Footer Template -->
<?php include('template/footer.php'); ?>
<!-- End Footer Template -->
</body>
</html>
