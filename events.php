




<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Events</title>
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

	if(isset($_GET['action'])){
		// We have a new event submittion
		if($_GET['action'] == "new_event"){

			// Get Level Authority
			$auth_level = $_SESSION['AuthLevel'];

			// Does user have authority to create event
			if(isset($_SESSION['Member_Id']) and $auth_level == 3){

				// Vars for event
				$member_id = $_SESSION['Member_Id'];
				$event_description = $_POST['event_description'];
				$event_title = $_POST['event_title'];
				$event_date = $_POST['event_date'];
				$artist_id = $_POST['artist_id'];


				// Prepare the query for inserting the event
				  $new_event_statement = $dbh->prepare("INSERT INTO Event (Event_Date, Event_Descrip, Event_Title) 
						VALUES(:event_date, :event_description, :event_title)");

				  // Load variables into prepared query
				$new_event_statement->execute(array(
										  ":event_date" => $event_date,
										  ":event_description" => $event_description,
										  ":event_title" => $event_title));

				// Get the event id so we can bind the image to the event
				$event_id = $dbh->lastInsertId();

				// Check if insert was successful
				if($new_event_statement->rowCount() > 0) {

					echo "<div class='success_message'>Your event was successfully made</div>";

					// Seperate's string at .
					$temp = explode(".",basename($_FILES["event_image"]["name"]));
					$file_ext = end($temp);

					// Insert image into images
					$new_image_stmt = $dbh->prepare("INSERT INTO Image (Img_Ref) Values(:img_ref)");
					$new_image_stmt->execute(array(":img_ref" => $file_ext));

					$image_id = $dbh->lastInsertId();

					// Set reference between event id and image id
					$link_event_image_stmt = $dbh->prepare("INSERT INTO EventImage (Img_Id,Event_Id) Values (:img_id,:event_id)");
					$link_event_image_stmt->execute(array(":img_id" => $image_id,":event_id" => $event_id));

					if($artist_id !== ""){
						$link_event_artist_stmt = $dbh->prepare("INSERT INTO ArtistEvent (Artist_Id, Event_Id) Values(:artist_id,:event_id)");
						$link_event_artist_stmt ->execute(array(":artist_id" => $artist_id, ":event_id" => $event_id));
					}

					// Upload image (name = Img_Id)

					// folder for uploaded images
					$target_dir = "user_images/";

					// Seperate's string at .
					$temp = explode(".",basename($_FILES["event_image"]["name"]));

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
					if($_FILES["event_image"]["size"] > 250000){
						echo "File size is too large";
						$uploadOk = 0;
					}

					// Try and upload file

					if($uploadOk == 0){
						echo "Sorry file was not uploaded";
					} else {
						if (move_uploaded_file($_FILES["event_image"]["tmp_name"], $target_file)) {
							  //echo "The file ". basename( $_FILES["event_image"]["name"]). " has been uploaded.";
						} else {
							  echo "Sorry, there was an error uploading your file.";
						}
					}


				}
				else {
					echo "<div class='error_message'>Your event was not submitted, please try again</div>";
				}

			}
			else {

				// Display error, user not allowed to make event
				echo "<div class='error_message'>You must be logged in to create a event</div>";
			}

		}
		else if($_GET['action'] == "edit_event"){

			// Check that this user owns this event
			$event_id = $_GET["event_id"];

			// Who is logged in
			$member_id = $_SESSION["Member_Id"];

			// Get member_id of owner of this event
			$event_stmt = $dbh->prepare("Select * From Event WHERE Event_Id=:event_id");
			$event_stmt->execute(array(":event_id"=>$event_id));

			$row = $event_stmt->fetch();

			// Make sure its the admin trying to edit the event
			if($_SESSION['AuthLevel'] == 3){

				// All good this user owns this event
				$new_event_description = $_POST["event_description"];
				$new_event_date = $_POST["event_date"];
				$new_event_title = $_POST["event_title"];

				// Update the Description and expiry date
				$event_update_stmt = $dbh->prepare("Update Event Set Event_Descrip=:new_event_descrip, Event_Date=:event_date, Event_Title=:event_title
					WHERE Event_Id=:event_id");
				$event_update_stmt->execute(array(
					":new_event_descrip" => $new_event_description, 
					":event_date" => $new_event_date,
					":event_title" => $new_event_title,
					":event_id" => $event_id
					));

				echo "<div class='success_message'>Event Updated</div>";

				// Check if they want the picture changed
				if($_FILES["event_image"]["name"] === ""){

					// echo "Don't want pic changed";

				} else {

					// Insert the new picture and bind it to this event

					// Seperate's string at .
					$temp = explode(".",basename($_FILES["event_image"]["name"]));
					$file_ext = end($temp);

						// Insert image into images
						$new_image_stmt = $dbh->prepare("INSERT INTO Image (Img_Ref) Values(:img_ref)");
						$new_image_stmt->execute(array(":img_ref" => $file_ext));

						$image_id = $dbh->lastInsertId();

						// Set reference between event id and image id
						$link_event_image_stmt = $dbh->prepare("Update EventImage SET Img_Id=:img_id WHERE Event_Id=:event_id");
						$link_event_image_stmt->execute(array(":img_id" => $image_id,":event_id" => $event_id));

						// folder for uploaded images
					$target_dir = "user_images/";

					// Seperate's string at .
					$temp = explode(".",basename($_FILES["event_image"]["name"]));

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
					if($_FILES["event_image"]["size"] > 250000){
						echo "File size is too large";
						$uploadOk = 0;
					}

					// Try and upload file

					if($uploadOk == 0){
						echo "Sorry file was not uploaded";
					} else {
						if (move_uploaded_file($_FILES["event_image"]["tmp_name"], $target_file)) {
							  echo "The file ". basename( $_FILES["event_image"]["name"]). " has been uploaded.";
						} else {
							  echo "Sorry, there was an error uploading your file.";
						}
					}
				}

			} else {
				echo "<div class='error_message'>Events can only be edited by the admin</div>";
			}

		}
		else if($_GET['action'] == "delete_event"){

			// Check that this user owns this event
			$event_id = $_GET["event_id"];

			// Who is logged in
			$member_id = $_SESSION["Member_Id"];

			// Get member_id of owner of this event
			$event_stmt = $dbh->prepare("Select * From Event WHERE Event_Id=:event_id");
			$event_stmt->execute(array(":event_id"=>$event_id));

			$row = $event_stmt->fetch();

			if($_SESSION["AuthLevel"] == 3){

				$delete_event_stmt = $dbh->prepare("Delete FROM Event WHERE Event_Id=:event_id");
				$delete_event_stmt->execute(array(":event_id" => $event_id));

			}
		}
	}
	?>
	<a href="add_event.php">Add Event</a>
    	<h1>Events</h1>

	<?php

		// Outputting all events
		$all_event_stmt = $dbh->prepare("Select * FROM Event WHERE Event_Date >= CURRENT_TIMESTAMP ORDER BY Event_Date ASC");
		$all_event_stmt->execute();

		while($row = $all_event_stmt->fetch()){

			// Check if this event is binded to a featured artist
			$is_event_featured_stmt = $dbh->prepare("Select * FROM FeaturedArtist WHERE FeaturedArtist_Id = (Select Artist_Id FROM ArtistEvent WHERE Event_Id=:event_id)");
			$is_event_featured_stmt->execute(array(":event_id" => $row["Event_Id"]));

			 $is_featured = false;

			if($is_event_featured_stmt->rowCount() > 0) {
			
				// This is the featured artist
				//$is_featured = true;
			}

			$event_row = $is_event_featured_stmt->fetch();
			




			// Get the image associated to this event
			$event_image_stmt = $dbh->prepare("Select * From Image Where Img_Id=(Select Img_Id From EventImage Where Event_Id=:event_id)");
			$event_image_stmt->execute(array(":event_id" => $row["Event_Id"]));

			$image_row = $event_image_stmt->fetch();
			$image_id  = $image_row["Img_Id"];

			echo "<div class='event_group'>";

			if($is_featured){
				// Link to featured artist using FeaturedArtist_Id
				echo "<a href='artist.php?artist_id=" . $event_row["FeaturedArtist_Id"] . "'><h1 class='event_title'>" . $row["Event_Title"] . "</div></a>";
			}
			else {
				echo "<h1 class='event_title'>" . $row["Event_Title"] . "</h1>";
			}

			echo "<img class='event_image' src='user_images/". (String)$image_id . "." . $image_row["Img_Ref"] . "'/>"; 

			echo "<div class='event_description'>" . $row["Event_Descrip"] . "</div>";

			// Some way to link to the featured artist

			if(isset($_SESSION["Member_Id"])){
				//if($_SESSION["Member_Id"] == 3){
					echo "<div class='event_controls'>";
					echo "<a href='edit_event.php?event_id=" . $row["Event_Id"] . "'>Edit</a>|";
					echo "<a href='events.php?action=delete_event&event_id=" . $row["Event_Id"] . "'>Delete</a></div>";
				//}
			}

			echo "</div>";

		}
	?>
	</table>
</div>
</div>
<!-- End of all Content -->

<!-- Footer Template -->
<?php include('template/footer.php'); ?>
<!-- End Footer Template -->


</body>
</html>


