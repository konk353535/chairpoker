




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
		session_start();

		include("db_connect.php");

		if(isset($_SESSION["Member_Id"])){

			// What notice do we want to edit
			$notice_id = $_GET["notice_id"];
			
			// Who is logged in
			$member_id = $_SESSION["Member_Id"];

			// Get member_id of owner of this notice
			$notice_stmt = $dbh->prepare("Select * From Notice WHERE Notice_Id=:notice_id");
			$notice_stmt->execute(array(":notice_id" => $notice_id));

			$row = $notice_stmt->fetch();
			if($row["Notice_MemberId"] == $member_id){

				// All good this user owns this notice
				$notice_description = $row["Notice_Descrip"];
				$notice_expiry_date = $row["Notice_ExpDate"];

			}
			else {

				// Bad this user doesnt own this notice
				echo "You don't own this notice";
			}
		}
	?>

    <!-- Main Content Here -->
      <h1>Edit Notice</h1>
   	<form name="loginForm" method="post" action='notices.php?action=edit_notice&notice_id=<?php echo $_GET["notice_id"]; ?>'  onsubmit="return input_validate_notice()" enctype="multipart/form-data">

		<label class="label">Notice Expiry Date</label>
		<input class="full_width" name="notice_expiry_date" type="text"  placeholder="Expiry Date" id="expiry_date" value=<?php echo $notice_expiry_date; ?>>

		<label class="label">Notice Description</label>
		<textarea class="full_width no_resize" name="notice_description" id="notice_description" rows="10" ><?php echo $notice_description; ?></textarea>

		<label class="label">Notice Image</label>
		<input type="file" name="notice_image" id="notice_image">

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