




<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Townsville Community Music Centre</title>
	<link href="mainstyle.css" rel="stylesheet" type="text/css">

	<!-- Google Fonts Open Sans -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

	<!-- Date Picker -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
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
			include("db_connect.php");
			// deny unpaid users
			if(!isset($_SESSION['Member_Id']) && $_SESSION['AuthLevel'] >= 2){
				echo "<div class='error_message'>You can only submit Artists if you are a paid member!</div>";
			} else {
				
		?>
		<!-- Main Content Here -->
      <h1>New Artist</h1>
   	<form name="loginForm" method="post" action="artists.php?action=new_artist" onsubmit="return input_validate_artist()" enctype="multipart/form-data">

		<label class="label" for="artist_fnames">First name:</label>
		<input class="block" name="artist_fnames" type="text" id="artist_fnames">
		<label class="label" for="artist_sname">Surname:</label>
		<input class="block" name="artist_sname" type="text" id="artist_sname">
		<label class="label" for="artist_email">Email:</label>
		<input class="block" name="artist_email" type="text" id="artist_email">
		<label class='label' for="artist_phoneday">Daytime Phone</label>
		<input class="block" name="artist_phoneday" type="text" id="artist_phoneday">
		<label class='label' for="artist_mobile">Mobile Phone:</label>
		<input class="block" name="artist_mobile" type="text" id="artist_mobile">

		<label class="label" for="artist_description">Artist Brief:</label>
		<textarea class="full_width no_resize" name="artist_description" id="artist_description" rows="10"></textarea>

		<label class="label" for="artist_image">Artist Image</label>
		<input type="file" name="artist_image" id="artist_image">

		<input type="submit" name="button" value="Submit" >
	</form>
	<div id="errorOutput"></div>
    <!-- End of Main Content -->

		<?php
			}
		?>
	</div>
</div>