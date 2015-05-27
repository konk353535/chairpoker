<?php
	session_start();
	if(!isset($_SESSION['AuthLevel']) || $_SESSION['AuthLevel'] != 3){
		// just sending to a page with html on it which will display error for me
		header("Location: adminMemberEdit.php");
	}
	
	include("db_connect.php");
	var_dump($_POST);
	$updateMemberStatement = $dbh->prepare("UPDATE Member SET Member_Email = ?,
																Member_Fname = ?,
																Member_Sname = ?,
																Member_AuthLevelId = ?
																WHERE Member_Id = ?");
	$updateMemberStatement->execute(array($_POST['Member_Email'],
										  $_POST['Member_Fname'],
										  $_POST['Member_Sname'],
										  $_POST['Member_AuthLevel'],
										  $_POST['Member_Id']));
	$message = "";
	if($updateMemberStatement->rowCount() > 0){
		$message = "Successfully updated " . $_POST['Member_Fname'] . " " . $_POST['Member_Sname'] . "'s details!";
		header("Location: adminMemberList.php?success_message=" . $message);
	} else {
		$message = "Failed to update Member.";
		header("Location: adminMemberList.php?error_message=" . $message);
	}
	exit();
?>