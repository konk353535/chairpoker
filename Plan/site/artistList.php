<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<title></title>
</head>
<body>

<?php 
	include("db_connect.php");

	$artists = $dbh->query("SELECT * FROM Artist");

	//write summary of every artist retrieved in $artists
	foreach ($artists as $row) {
		$artist_id = $row["A_Id"];
		echo "<h1>Artist Title: <a href='artistDetails.php?artist_id=" . $artist_id . "'>" . $row["A_Title"] . "</a></h1><br/>";
		$main_image = $dbh->query("SELECT Img_Ref FROM Image WHERE Img_Id IN (
									SELECT A_MainImageId FROM Artist WHERE A_Id = " . $artist_id . ")");
		$all_images = $dbh->query("SELECT Img_Ref FROM Image WHERE Img_Id IN (
									SELECT Img_Id FROM ArtistImage WHERE A_Id = " . $artist_id . ")");
		$image_count_lookup = $dbh->query("SELECT COUNT(*) FROM Image WHERE Img_Id IN (
								SELECT Img_Id FROM ArtistImage WHERE A_Id = " . $artist_id . ")");
		$image_count = $image_count_lookup->fetch()[0];
		// there's only one row in $main_image
		$main_image_row = $main_image->fetch(PDO::FETCH_ASSOC);

		// check if this artist has a main image assigned
		if(!is_null($main_image_row["Img_Ref"]))
		{
			echo "<a href='artistDetails.php?artist_id=" . $artist_id . "'><img src='../db/" . $main_image_row["Img_Ref"] . "'></a><br/>";
		}
		// use f'n something if there isn't one assigned
		else if($image_count > 0)
		{
			$chosen_row = $all_images->fetch(PDO::FETCH_ASSOC);
			echo "<a href='artistDetails.php?artist_id=" . $artist_id . "'><img src='../db/" . $chosen_row["Img_Ref"] . "'></a><br/>";
		}
		else
		{
			echo "<p>No image found</p>";
		}

		//lazy filler space
		echo "<br/><hr><br/>\n";

	}


?>
<a href="index.html">Return</a>
</body>
</html>