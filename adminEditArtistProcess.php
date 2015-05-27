<?php
	session_start();
	if(!isset($_SESSION['AuthLevel']) || $_SESSION['AuthLevel'] != 3){
		// just sending to a page with html on it which will display error for me
		header("Location: adminEditArtist.php");
	}

	include("db_connect.php");
	try {
		$dbh->beginTransaction();
		$updateArtistStatement = $dbh->prepare("UPDATE Artist SET Artist_Email =?,
																	Artist_Fnames = ?,
																	Artist_Sname = ?,
																	Artist_PhoneDay = ?,
																	Artist_Mobile = ?
																	WHERE Artist_Id = ?");
		
		$updateArtistStatement->execute(array($_POST['Artist_Email'], 
											  $_POST['Artist_Fnames'], 
											  $_POST['Artist_Sname'],
											  $_POST['Artist_PhoneDay'],
											  $_POST['Artist_Mobile'],
											  $_POST['Artist_Id']));
		// admittedly lazy implementation of updating categories, could check to see what is and isn't already present 
		$clearCategories = $dbh->prepare("DELETE FROM ArtistCategory WHERE Artist_Id = ?");
		$clearCategories->execute(array($_POST['Artist_Id']));
		
		for($i = 1; $i <= $_POST['NumberOfCategories']; $i++){
			$addCatStatement = $dbh->prepare("INSERT INTO ArtistCategory (Category_Id, Artist_Id) VALUES (?, ?)");
			$addCatStatement->execute(array($_POST['ArtistCategory' . $i], $_POST['Artist_Id']));
		}
		$dbh->commit();
		
	} catch (PDOException $e) {
		$dbh->rollBack();
		$message = "Failed to update Artist: " . $e->getMessage();
		header("Location: adminArtistList.php?error_message=" . $message);
		exit();
	}
	if($updateArtistStatement->rowCount() > 0){
		$message = "Successfully updated " . $_POST['Artist_Fnames'] . " " . $_POST['Artist_Sname'] . "'s details!";
		header("Location: adminArtistList.php?success_message=" . $message);
		exit();
	} else {
		$message = "Failed to update Artist.";
		header("Location: adminArtistList.php?error_message=" . $message);
		exit();
	}
?>