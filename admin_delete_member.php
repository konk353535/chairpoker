<?php
	session_start();
	if(!isset($_SESSION['AuthLevel']) || $_SESSION['AuthLevel'] != 3){
		header("Location: index.php");
		exit();
	}
	include("db_connect.php");
	$delete_member_stmt = $dbh->prepare("DELETE FROM Member WHERE Member_Id = ?");
	$delete_member_stmt->execute(array($_GET['member_id']));

	if($delete_member_stmt->rowCount() > 0){
		$message = "Successfully deleted member!";
		header("Location: adminMemberList.php?success_message=" . $message);
	} else {
		$message = "Failed to delete member";
		header("Location: adminMemberList.php?error_message=" . $message);
	}
	exit();
	
?>