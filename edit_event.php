




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
<div class="allContent bgPrimary">
    <div class="mainContent">

    	<?php

		include("db_connect.php");

		if(isset($_SESSION["Member_Id"])){

			// What event do we want to edit
			$event_id = $_GET["event_id"];
			
			// Who is logged in
			$member_id = $_SESSION["Member_Id"];

			// Get member_id of owner of this event
			$event_stmt = $dbh->prepare("Select * From Event WHERE Event_Id=:event_id");
			$event_stmt->execute(array(":event_id" => $event_id));

			$row = $event_stmt->fetch();

			// Change this to 3 after testing it works
			if($_SESSION["AuthLevel"] == 3){

				$event_description = $row["Event_Descrip"];
				$event_date = $row["Event_Date"];
				$event_title = $row["Event_Title"];
			}
			else {

				// This user is not the admin
				echo "Only the admin can edit events";
			}
		}
	?>

    <!-- Main Content Here -->
      <h1>Edit Event</h1>
   	<form name="loginForm" method="post" action='events.php?action=edit_event&event_id=<?php echo $_GET["event_id"]; ?>'  onsubmit="return input_validate_event()" enctype="multipart/form-data">

		<label class="label">Event Date</label>
		<input class="full_width" name="event_date" type="text"  placeholder="Event Date" id="event_date" value=<?php echo $event_date; ?>>

		<label class="label">Event Title</label>
		<input class="full_width" name="event_title" type="text"  placeholder="Event title" id="event_title" <?php echo "value='". $event_title . "'"; ?>>

		<label class="label">Event Description</label>
		<textarea class="full_width no_resize" name="event_description" id="event_description" rows="10" ><?php echo $event_description; ?></textarea>

		<label class="label">Event Image</label>
		<input type="file" name="event_image" id="event_image">

		<input type="submit" name="button" value="Edit" >
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