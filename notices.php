<?php

// Begin session so we can check if the user is logged in
session_start();

include("db_connect.php");

// We have a new notice submittion
if($_GET['action'] == "new_notice" and isset($_SESSION['Member_Id'])){
	
	// Get Level Authority
	$auth_level = $_SESSION['AuthLevel'];

	if($auth_level >= 1){

		// Vars for notice
		$member_id = $_SESSION['Member_Id'];
		$notice_description = $_POST['notice_description'];
		$notice_expiry_date = $_POST['notice_expiry_date'];

		echo "Member_Id = " . $member_id . "<br />";
		echo "desc" . $notice_description . "<br />";
		echo "date" . $notice_expiry_date . "<br />";

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
    			echo "<div class='success_message'>Your notice was successfully made (Refresh to see it)</div>";
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

// Outputting all notices

$all_notice_stmt = $dbh->prepare("Select * FROM Notice");
$all_notice_stmt->execute();

while($row = $all_notice_stmt->fetch()){
	print_r($row);
	echo "<br /><br />";
}


?>