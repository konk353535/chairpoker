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
		echo "Artist Title: " . $row[A_Title] . "\n";
		echo "Contact Info\n<ul>\n<li>" . $row[A_Email] . 
						"</li>\n<li>Phone Daytime: " . $row[A_Phone] . 
						"</li>\n<li>Phone After Hours: " . $row[A_PhoneAfter] . 
						"</li>\n<li>Mobile: " . $row[A_Mobile] . 
						"</li>";
		$artist_id = $row[A_Id];
		$main_image = $dbh->query("SELECT A_MainImageId FROM Artist WHERE A_Id = " . $artist_id);

        //fix this, it be broke
		if(is_null($main_image.fetch_row()[A_MainImageId]) || $images->num_rows == 0)
		{
            echo "<p>No image found<p>";
		}
        else 
        {
            echo "<img src='" . $main_image->fetch()[Img_Ref] . "'>";
        }
		$images = $dbh->query("SELECT Img_Ref FROM Image WHERE A_Id = " . $artist_id);
		if($images->num_rows == 0)
		{
			echo "<p>No image found</p>";
		}
		else if($images->num_rows > 1)
		{
			$chosen_row = $images->fetch();
			echo "<img src='" . $chosen_row[Img_Ref] . "''>";
		}
	}

?>

<table>
<td>
<tr></tr>
</td>
<table>
</body>
</html>