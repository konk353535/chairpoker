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
		echo "Artist Title: " . $row["A_Title"] . "<br/>";
		echo "Contact Info:\n<ul>\n<li>Email: " . $row["A_Email"] . 
						"</li>\n<li>Phone Daytime: " . $row["A_PhoneDay"] . 
						"</li>\n<li>Phone After Hours: " . $row["A_PhoneAfter"] . 
						"</li>\n<li>Mobile: " . $row["A_Mobile"] . 
						"</li>\n</ul>\n";
		$artist_id = $row["A_Id"];
		$main_image = $dbh->query("SELECT Img_Ref FROM Image WHERE Img_Id IN (
									SELECT A_MainImageId FROM Artist WHERE A_Id = " . $artist_id . ")");

		$all_images = $dbh->query("SELECT Img_Ref FROM Images WHERE Img_Id IN (
									SELECT ImgId FROM ArtistImage WHERE A_Id = " . $artist_id . ")");
        // there's only one row in $main_image
        $main_image_row = $main_image->fetch(PDO::FETCH_ASSOC);

        // check if this artist has a main image assigned
        if(!is_null($main_image_row["Img_Ref"]))
        {
            echo "<a href='artistDetails.php'><img src='../db/" . $main_image_row["Img_Ref"] . "'></a><br/>";
        }
        // use f'n something if there isn't one assigned
		else if(count($all_images) > 1)
		{
			$chosen_row = $all_images->fetch(PDO::FETCH_ASSOC);
			echo "<a href='artistDetails.php'><img src='../db/" . $chosen_row["Img_Ref"] . "'></a><br/>";
		}
		else
        {
        	echo "<p>No image found</p>";
        }
	}

?>

</body>
</html>