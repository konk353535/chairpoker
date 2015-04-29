<?php include("db_connect.php"); ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php

	$artist_id = $_GET["artist_id"];
	$sql_delete_artist = "DELETE FROM Artist WHERE A_Id = " . $artist_id;

	$sql_delete_image_refs = "DELETE FROM ArtistImage WHERE A_Id = " . $artist_id;

	$sql_delete_artist_categories = "DELETE FROM ArtistCategory WHERE A_Id = " . $artist_id;

	try 
	{
		$dbh->beginTransaction();

		$dbh->exec($sql_delete_artist_categories);
		$dbh->exec($sql_delete_image_refs);
		$dbh->exec($sql_delete_artist);

		$dbh->commit();
		echo "<h1>Successfully deleted artist!</h1>";
	}
	catch(Exception $e)
	{
		$dbh->rollBack();
		"Error deleting artist: " . $e;
	}
	echo "<a href='deleteArtist.php'>Return</a>";

?>
</body>
</html>