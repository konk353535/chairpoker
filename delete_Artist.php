<?php
	if(!isset($_SESSION['AuthLevel']) || $_SESSION['AuthLevel'] == 1){
		// insert lazy comment for lazy redirect
		header("Location: index.php");
	}
	
	try{
		$dbh->beginTransaction();
		$delete_artist = $dbh->prepare("DELETE FROM Artist WHERE Artist_Id = ?");
		$delete_artist->execute(array($_GET['artist_id']));
		
	} catch(PDOException $e){
		$dbh->rollBack();
		echo "error deleting artist: " . $e->getMessage();
	}
?>