<?php include("db_connect.php") ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <?php
    	function createImageFileName($artist_title, $artist_id, $extension)
    	{
    		// remove whitespace before it breaks something
    		$artist_title = trim($artist_title);
    		
    		// the first 4 letters of words sepearated by spaces (if any) in $artist_title
    		// are used as part of the filename
    		$split_title = explode(" ", $artist_title);
    		
    		$result = "";
    		foreach($split_title as $prefix_portion)
    		{
    			//grab first 4 letters
    			$result .= substr($prefix_portion, 0, 4);
    		}
    		$result .= $artist_id;
    		$result .= $extension;
    		return $result;
    	}
    ?>

</head>
<body>
<?php

	$sql_insert_artist = "INSERT INTO Artist (A_Title, A_Email, A_PhoneDay, A_PhoneAfter, A_Mobile) VALUES ('"
		 . $_POST["A_Title"] . "', '"
		 . $_POST["A_Email"] . "', '"
		 . $_POST["A_PhoneDay"] . "', '"
		 . $_POST["A_PhoneAfter"] . "', '"
		 . $_POST["A_Mobile"] . "'"
		 . ")";
	
	try {
		// $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$dbh->beginTransaction();
		//put artist info into database
		$dbh->exec($sql_insert_artist);
		$new_artist_id = $dbh->lastInsertId();

		//get the stored image and put it in our directory
		$temp_image_filename = $_FILES['ArtistImage']['tmp_name'];
		//grab the file extension, eg ".jpg", ".bmp"
		$file_extension = substr($_FILES['ArtistImage']['name'], strrpos($_FILES['ArtistImage']['name'], '.'));
		//create the file name the file will be stored as
		$image_filename = createImageFileName($_POST["A_Title"], $new_artist_id, $file_extension);
		if(!move_uploaded_file($temp_image_filename, "../db/images/" . $image_filename))
		{
			throw new Exception("failed to upload image: " . $temp_image_filename);
		}

		//put image entry in Image table, uses new artist's id for filename, so needs to be a part of the transaction
		$sql_insert_image = "INSERT INTO Image (Img_Ref) VALUES ('images/" . $image_filename . "')";
		$dbh->exec($sql_insert_image);
		$new_image_id = $dbh->lastInsertId();
		//create association in ArtistImage
		$dbh->exec("INSERT INTO ArtistImage(A_Id, Img_Id) VALUES (" . $new_artist_id . ", " . $new_image_id . ")");
		// add A_MainImageId value now that we have information about the new image entry
		$dbh->exec("UPDATE Artist A_MainImageId = " . $new_image_id . " WHERE A_Id = " . $new_artist_id);
		//put category entry in ArtistCategory table
		$sql_insert_category = "INSERT INTO ArtistCategory (A_Id, C_Id) VALUES (" . $new_artist_id . ", " . $_POST["C_Id"] . ")";
		$dbh->exec($sql_insert_category);

		$dbh->commit();
	}
	catch(Exception $e)
	{
		$dbh->rollBack();
		echo "Failed to insert new Artist: " . $e->getMessage();
	}

	echo "<p>Successfully inserted new Artist!</p><br/>
		<a href='newArtist.php'>Back to form</a>";

?>
</body>
</html>