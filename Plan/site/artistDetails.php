<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Artist Details</title>
</head>
<body>

<?php
	include("db_connect.php");
	$artist_id = $_GET["artist_id"];

	$artist_row = $dbh->query("SELECT * FROM Artist WHERE A_Id = " . $artist_id)->fetch();

	echo "<h1>Artist Title: <a href='artistDetails.php?artist_id=" . $artist_id . "'>" . $artist_row["A_Title"] . "</a></h1>\n";

	$main_image = $dbh->query("SELECT Img_Ref FROM Image WHERE Img_Id IN (
								SELECT A_MainImageId FROM Artist WHERE A_Id = " . $artist_id . ")");
	$all_images = $dbh->query("SELECT Img_Ref FROM Image WHERE Img_Id IN (
								SELECT Img_Id FROM ArtistImage WHERE A_Id = " . $artist_id . ")");
	$image_count = $dbh->query("SELECT COUNT(*) FROM Image WHERE Img_Id IN (
								SELECT Img_Id FROM ArtistImage WHERE A_Id = " . $artist_id . ")")->fetch()[0];

	// there's only one row in $main_image
	$main_image_row = $main_image->fetch(PDO::FETCH_ASSOC);
	// check if this artist has a main image assigned
	if(!is_null($main_image_row["Img_Ref"]))
	{
		echo "<a href='artistDetails.php'><img src='../db/" . $main_image_row["Img_Ref"] . "'></a><br/>";
	}
	// use f'n something if there isn't one assigned
	else if($image_count > 0)
	{
		$chosen_row = $all_images->fetch(PDO::FETCH_ASSOC);
		echo "<a href='artistDetails.php'><img src='../db/" . $chosen_row["Img_Ref"] . "'></a><br/>";
	}
	else
	{
		echo "<p>No image found</p>";
	}

	$artist_categories = $dbh->query("SELECT C_Name FROM Category WHERE C_Id IN (
										SELECT C_Id FROM ArtistCategory WHERE A_Id = " . $artist_id . ")");
	$category_count = $dbh->query("SELECT COUNT(*) FROM Category WHERE C_Id IN (
										SELECT C_Id FROM ArtistCategory WHERE A_Id = " . $artist_id . ")")->fetch()[0];
	echo "\n<!--I'm not too sure what categories are at the time of writing this, but I'm putting them here to demonstrate that I can retrieve them -->\n";
	echo "<h2>Artist Categories: </h2>\n<ul>\n";
	if($category_count == 0)
	{
		echo "None"; 
	}
	else if($category_count == 1)
	{
		echo "<li>" . $artist_categories->fetch()[0] . "</li>\n";
	}
	else 
	{
		foreach ($artist_categories as $row) 
		{
			echo "<li>" . $row["C_Name"] . "</li>\n";
		}
	}
	echo "</ul>";
	echo "<h2>Contact Info:</h2>\n<ul>\n
			<li>Email: " . $artist_row["A_Email"] . "</li>\n" . 
			"<li>Phone Daytime: " . $artist_row["A_PhoneDay"] . "</li>\n" . 
			"<li>Phone After Hours: " . $artist_row["A_PhoneAfter"] . "</li>\n" . 
			"<li>Mobile: " . $artist_row["A_Mobile"] . "</li>\n" . 
			"</ul>";

?>
<a href="artistList.php">Return</a>
</body>
</html>