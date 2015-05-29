<?php
	if(!isset($_SESSION['AuthLevel']) || $_SESSION['AuthLevel'] != 3){
		// insert lazy comment for lazy redirect
		header("Location: index.php");
	}
	
	try{
		$dbh->beginTransaction();
		$delete_artist = $dbh->prepare("DELETE FROM Artist WHERE Artist_Id = ?");
		$delete_artist->execute(array($_GET['artist_id']));
		$delete_cats = $dbh->prepare("DELETE FROM ArtistCategory WHERE Artist_Id = ?");
		$delete_cats->execute(array($_GET['artist_id']));
		$dbh->commit();
		$message = "Successfully deleted Artist!";
		header("Location: adminArtistList.php?success_message=" . $message);
		exit();
	} catch(PDOException $e){
		$dbh->rollBack();
		echo "error deleting artist: " . $e->getMessage();
	}
?>