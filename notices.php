




<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Notices</title>
	<link href="mainstyle.css" rel="stylesheet" type="text/css">

	<!-- Google Fonts Open Sans -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

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

	// Begin session so we can check if the user is logged in
	session_start();

	include("db_connect.php");

	// We have a new notice submittion
	if($_GET['action'] == "new_notice"){
		
		// Get Level Authority
		$auth_level = $_SESSION['AuthLevel'];

		// Does user have authority to create notice
		if(isset($_SESSION['Member_Id']) and $auth_level >= 1){

			// Vars for notice
			$member_id = $_SESSION['Member_Id'];
			$notice_description = $_POST['notice_description'];
			$notice_expiry_date = $_POST['notice_expiry_date'];

			// Prepare the query for inserting the notice
		      $new_notice_statement = $dbh->prepare("INSERT INTO Notice (Notice_ExpDate, Notice_Descrip, Notice_MemberId) 
		      		VALUES(:notice_date, :notice_description, :member_id)");

		      // Load variables into prepared query
			$new_notice_statement->execute(array(
	                                  ":notice_date" => $notice_expiry_date,
	                                  ":notice_description" => $notice_description,
	                                  ":member_id" => $member_id));

			// Check if insert was successful
	    		if($new_notice_statement->rowCount() > 0) {
	    			echo "<div class='success_message'>Your notice was successfully made</div>";
	    		}
	    		else {
	    			echo "<div class='error_message'>Your notice was not submitted, please try again</div>";
	    		}

		}
		else {

			// Display error, user not allowed to make notice
			echo "<div class='error_message'>You must be logged in to create a notice</div>";
		}

	}
	?>
    	<h1>All Notices</h1>
	<?php

		// Outputting all notices
		$all_notice_stmt = $dbh->prepare("Select * FROM Notice");
		$all_notice_stmt->execute();

		while($row = $all_notice_stmt->fetch()){

			echo $row["Notice_Descrip"] . "<br />";
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


