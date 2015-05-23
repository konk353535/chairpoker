<?php
session_start();

include("db_connect.php");

if(isset($_SESSION["Member_Id"])){

	// What notice do we want to edit
	$notice_id = $_GET["notice_id"];
	
	// Who is logged in
	$member_id = $_SESSION["member_id"];

	// Get member_id of owner of this notice
	$notice_stmt = $dbh->prepare("Select * From Notice WHERE Notice_Id");
	$notice_stmt->execute();

	$row = $notice_stmt->fetch();

	if($row["Notice_MemberId"] == $member_id){
		// All good this user owns this notice
		echo "Good";
	}
	else {
		// Bad this user doesnt own this notice
		echo "Bad";
	}
}



?>