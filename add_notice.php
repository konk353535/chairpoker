




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
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script>
	$(function(){
		$("#expiry_date").datepicker({ dateFormat: 'yy-mm-dd'});
	});
	</script>
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
		// Connect to our database
		include("db_connect.php");

		// Check that user is logged in (only registered users can make notices)
		if(!isset($_SESSION['Member_Id'])){
			echo "<div class='error_message'>You can only make notices if you are logged in, please log in</div>";
		}

		// Display the add notice form either way
		// As we can check if they're logged in when we are trying to submit the data
	?>

    <!-- Main Content Here -->
      <h1>New Notice</h1>
   	<form name="loginForm" method="post" action="notices.php?action=new_notice" onsubmit="return input_validate_notice()" enctype="multipart/form-data">

		<label class="label">Notice Expiry Date</label>
		<input class="full_width" name="notice_expiry_date" type="text"  placeholder="Expiry Date" id="expiry_date">

		<label class="label">Notice Description</label>
		<textarea class="full_width no_resize" name="notice_description" id="notice_description" rows="10"></textarea>

		<label class="label">Notice Image</label>
		<input type="file" name="notice_image" id="notice_image">

		<input type="submit" name="button" value="Submit" >
	</form>
	<div id="errorOutput"></div>
    <!-- End of Main Content -->

    </div>
</div>
<!-- End of all Content -->

<!-- Footer Template -->
<?php include("template/footer.php"); ?>
<!-- End Footer Template -->

<script>
	function input_validate_notice(){
		if(document.getElementById("expiry_date").value === ""){
			document.getElementById("errorOutput").innerHTML = "<div class='error_message'>Expiry date required</div>";
			return false;
		}
		else if(document.getElementById("notice_description").value === ""){
			document.getElementById("errorOutput").innerHTML = "<div class='error_message'>Notice description required</div>";
			return false;
		}
		else {
			document.getElementById("errorOutput").innerHTML = "";
			return true;
		}
	}
</script>
</body>
</html>