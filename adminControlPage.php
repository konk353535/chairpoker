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
			if(!isset($_SESSION['AuthLevel']) || $_SESSION['AuthLevel'] != 3){
				echo "<div class='error_message'>You need to be logged in with administrator rights to access this resource</div>";
			}
			else{
		?>
			<ul>
				<li>
					<a class='styledLink' href='adminMemberList.php'>Members</a>
				</li>
				<li>
					<a class='styledLink' href='adminArtistList.php'>Artists</a>
				</li>
				<li>
					<a class='styledLink' href='adminArtistCategories.php'>Artist Category Types</a>
				</li>
				<li>
					<a class='styledLink' href='adminNotices.php'>Bulletin board submissions</a>
				</li>
			</ul>
		<?php
			}
		?>
	  	
	</div>
</div>
<!-- End of all Content -->

<!-- Footer Template -->
<?php include('template/footer.php'); ?>
<!-- End Footer Template -->
</body>
</html>
