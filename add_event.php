




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
		$("#event_date").datepicker({ dateFormat: 'yy-mm-dd'});
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
<div class="allContent bgPrimary">
    <div class="mainContent">

    	<?php
		// Connect to our database
		include("db_connect.php");

		// Check that user is logged in (only registered users can make events)
		$auth_level = $_SESSION['AuthLevel'];

		if(isset($_SESSION['Member_Id'])){
			if($auth_level < 3){
				// User is registered
				echo "<div class='error_message'>Only the admin can make events</div>";
			}
		}
		else{
			echo "<div class='error_message'>You can only make events if you are logged in, please log in</div>";
		}

		// Display the add event form either way
		// As we can check if there logged in when we are trying to submit the data
	?>

    <!-- Main Content Here -->
      <h1>New Event</h1>
   	<form name="loginForm" method="post" action="events.php?action=new_event" onsubmit="return input_validate_event()" enctype="multipart/form-data">

		<label class="label">Event Date</label>
		<input class="full_width" name="event_date" type="text"  placeholder="Event Date" id="event_date">

		<label class="label">Event Title</label>
		<input class="full_width" name="event_title" type="text"  placeholder="Event Title" id="event_title">

		<label class="label">Event Description</label>
		<textarea class="full_width no_resize" name="event_description" id="event_description" rows="10"></textarea>

		<label class="label">Event Image</label>
		<input type="file" name="event_image" id="event_image">

		<input type="submit" name="button" value="Submit" >
	</form>
	<div id="errorOutput"></div>
    </div>
</div>
<!-- End of all Content -->

<!-- Footer Template -->

<div class="wrapper bgPrimary">
    <div class="footer">
        Footer Content 
    </div>
</div>

<!-- End Footer Template -->

<script>
	function input_validate_event(){
		if(document.getElementById("event_date").value === ""){
			document.getElementById("errorOutput").innerHTML = "<div class='error_message'>Event date required</div>";
			return false;
		}
		else if(document.getElementById("event_description").value === ""){
			document.getElementById("errorOutput").innerHTML = "<div class='error_message'>Event description required</div>";
			return false;
		}
		else if(document.getElementById("event_title").value === ""){
			document.getElementById("errorOutput").innerHTML = "<div class='error_message'>Event description required</div>";
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