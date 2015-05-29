




<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Artists</title>
	<link href="mainstyle.css" rel="stylesheet" type="text/css">

	<!-- Google Fonts Open Sans -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

</head>

<body>

<!-- Logo + Login Form + Text Title -->
<?php include('template/header.php'); ?>
<!-- End of header (Logo/LoginForm/TextTitle) -->

<!-- Nav Bar -->
<?php include('template/inc_nav.php'); ?>

<!-- All Content -->
<div class="allContent bgPrimary">
	<div class="mainContent">
  	<?php

	include("db_connect.php");

	// We have a new artist submition
	if(isset($_GET['action']) && $_GET['action'] == "new_artist"){
		// Get Level Authority
		$auth_level = $_SESSION['AuthLevel'];
		// Does user have authority to create artist
		if(isset($_SESSION['Member_Id']) and $auth_level >= 2){
			$artist_email = $_POST['artist_email'];
			$artist_fnames = $_POST['artist_fnames'];
			$artist_sname = $_POST['artist_sname'];
			$artist_phoneday = $_POST['artist_phoneday'];
			$artist_mobile = $_POST['artist_mobile'];
			$artist_description = $_POST['artist_description'];
			// Prepare the query for inserting the artist
			  $new_artist_statement = $dbh->prepare("INSERT INTO Artist (Artist_Email, Artist_Fnames, Artist_Sname, Artist_PhoneDay, Artist_Mobile, Artist_Descrip) VALUES(?, ?, ?, ?, ?, ?)");
			$new_artist_statement->execute(array(
										$artist_email,
										$artist_fnames,
										$artist_sname,
										$artist_phoneday,
										$artist_mobile,
									    $artist_description));
			// Get the artist id so we can bind the image to the artist
			$artist_id = $dbh->lastInsertId();
			// Check if insert was successful
				if($new_artist_statement->rowCount() > 0) {
					echo "<div class='success_message'>Your artist was successfully added</div>";
					// Seperate's string at .
					$temp = explode(".",basename($_FILES["artist_image"]["name"]));
					$file_ext = end($temp);
					// Insert image into images
					try {
						$dbh->beginTransaction();

						$new_image_stmt = $dbh->prepare("INSERT INTO Image (Img_Ref) Values(:img_ref)");
						$new_image_stmt->execute(array(":img_ref" => $file_ext));
						$image_id = $dbh->lastInsertId();
						// Set reference between artist id and image id
						$link_artist_image_stmt = $dbh->prepare("INSERT INTO ArtistImage (Img_Id,Artist_Id) Values (:img_id,:artist_id)");
						$link_artist_image_stmt->execute(array(":img_id" => $image_id,":artist_id" => $artist_id));
						// Upload image (name = Img_Id)
						// folder for uploaded images
						$target_dir = "user_images/";
						// Seperate's string at .
						$temp = explode(".",basename($_FILES["artist_image"]["name"]));
						// Constructs new image name
						$new_file_name = (String)$image_id . "." . end($temp);
						// Set where we want the image saved
						$target_file = $target_dir . $new_file_name;
						// Var that checks if we want to let the file be uploaded
						$uploadOk = 1;
						// Check if file exists
						if(file_exists($target_file)){
							echo "Sorry that file already exists";
							$uploadOk = 0;
						}
						// Check size of the file
						if($_FILES["artist_image"]["size"] > 250000){
							echo "File size is too large";
							$uploadOk = 0;
						}
						// Try and upload file
						if($uploadOk == 0){
							echo "Sorry file was not uploaded";
						} else {
							if (move_uploaded_file($_FILES["artist_image"]["tmp_name"], $target_file)) {
								 // echo "The file ". basename( $_FILES["artist_image"]["name"]). " has been uploaded.";
							} else {
								 // echo "Sorry, there was an error uploading your file.";
							}
						}
						$dbh->commit();
					} catch(PDOException $e){
						$dbh->rollBack();
						echo "<div class='error_message'>Database access failure:" . $e->getMessage() . "</div>";
					}
				}
				else {
					echo "<div class='error_message'>Your artist was not submitted, please try again</div>";
				}
		}
		else {
			// Display error, user not allowed to make artist
			echo "<div class='error_message'>You must be logged in to create a artist</div>";
		}
	} else if(isset($_GET['action']) && $_GET['action'] == "delete_artist"){
		if(isset($_SESSION['AuthLevel']) && $_SESSION['AuthLevel'] >= 2){
			try{
				$dbh->beginTransaction();
				$delete_artist = $dbh->prepare("DELETE FROM Artist WHERE Artist_Id = ?");
				$delete_artist->execute(array($_GET['artist_id']));
				$delete_cats = $dbh->prepare("DELETE FROM ArtistCategory WHERE Artist_Id = ?");
				$delete_cats->execute(array($_GET['artist_id']));
				$delete_img = $dbh->prepare("DELETE FROM ArtistImage WHERE Artist_Id = ?");
				$delete_img->execute(array($_GET['artist_id']));
				$dbh->commit();
			} catch(PDOException $e){
				$dbh->rollBack();
				echo "<div class='error_message'>error deleting artist: " . $e->getMessage() . "</div>";
			}
		}
	} else if(isset($_GET['action']) && $_GET['action'] == "edit_artist"){
		if(isset($_SESSION['AuthLevel']) && $_SESSION['AuthLevel'] >= 2){
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
				echo "<div class='error_message'>" . $message . "</div>";
			}
			if($updateArtistStatement->rowCount() > 0){
				$message = "Successfully updated " . $_POST['Artist_Fnames'] . " " . $_POST['Artist_Sname'] . "'s details!";
				echo "<div class='success_message'>" . $message . "</div>";
			} else {
				$message = "Failed to update Artist.";
				echo "<div class='error_message'>" . $message . "</div>";
			}
			
		}
	}
	?>
	
	<a href="add_artist.php">Add Artist</a>
    	<h1>Artists</h1>



<?php
		// Outputting all artists
		$artists = $dbh->query("SELECT * FROM Artist");
		while($row = $artists->fetch()){
			// Get the first image associated to this artist
			$artist_image = $dbh->query("SELECT * FROM Image WHERE Img_Id = (Select Img_Id From ArtistImage WHERE Artist_Id = " . $row['Artist_Id'] . ")");
			$image_row = $artist_image->fetch();
			$image_id  = $image_row["Img_Id"];
			echo "<div class='artist_group'>";
			echo "<h2 class='artist_title'><a href='artist.php?artist_id=" . $row['Artist_Id'] . "'>" . $row['Artist_Fnames'] . " " . $row['Artist_Sname'] . "</a></h2>";
			echo "<img class='artist_image' src='user_images/". (String)$image_id . "." . $image_row["Img_Ref"] . "'/>";
			$num_cats = $dbh->query("SELECT COUNT(*) FROM Category WHERE Category_Id IN (SELECT Category_Id FROM ArtistCategory WHERE Artist_Id = " . $row['Artist_Id'] . ")")->fetchColumn();
			
			echo "<div class='artist_description'><p>" . $row["Artist_Descrip"] . "</p>";
			if($num_cats > 0){
				$artist_categories = $dbh->query("SELECT * FROM Category WHERE Category_Id IN (SELECT Category_Id FROM ArtistCategory WHERE Artist_Id = " . $row['Artist_Id'] . ")");
				$sub_row = $artist_categories->fetch();
				echo "<p>This artist has the following categories: " . $sub_row['Category_Name'];
				while($sub_row = $artist_categories->fetch()){	
					echo ", " . $sub_row['Category_Name'];
				}
				echo "</p>";
			}
			echo "</div>";
			if(isset($_SESSION["Member_Id"])){
				if($_SESSION['AuthLevel'] == 3){
					echo "<div class='edit_controls'><a href='edit_artist.php?artist_id=" . $row["Artist_Id"] . "'>Edit</a>|";
					echo "<a href='artists.php?action=delete_artist&artist_id=" . $row["Artist_Id"] . "'>Delete</a></div>";
				}
			}
			echo "</div>";
		}
	?>
    
</div>
</div>
<!-- End of all Content -->

<!-- Footer Template -->

<?php include('template/footer.php'); ?>

<!-- End Footer Template -->

</body>
</html>