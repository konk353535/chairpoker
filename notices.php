




<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Notices</title>
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
<div class="allContent">
    <div class="mainContent bgPrimary">
  	<?php

	// Begin session so we can check if the user is logged in
	session_start();

	include("db_connect.php");

	// We have a new notice submittion
	if($_GET['action'] == "new_notice"){
		
		// Get Level Authority
		$auth_level = $_SESSION['AuthLevel'];

		// Does user have authority to create notice
		if(isset($_SESSION['Member_Id']) and $auth_level >= 1){

			// Vars for notice
			$member_id = $_SESSION['Member_Id'];
			$notice_description = $_POST['notice_description'];
			$notice_expiry_date = $_POST['notice_expiry_date'];

			// Prepare the query for inserting the notice
		      $new_notice_statement = $dbh->prepare("INSERT INTO Notice (Notice_ExpDate, Notice_Descrip, Notice_MemberId) 
		      		VALUES(:notice_date, :notice_description, :member_id)");

		      // Load variables into prepared query
			$new_notice_statement->execute(array(
	                                  ":notice_date" => $notice_expiry_date,
	                                  ":notice_description" => $notice_description,
	                                  ":member_id" => $member_id));

			// Get the notice id so we can bind the image to the notice
			$notice_id = $dbh->lastInsertId();

			// Check if insert was successful
	    		if($new_notice_statement->rowCount() > 0) {

	    			echo "<div class='success_message'>Your notice was successfully made</div>";

	    			// Seperate's string at .
				$temp = explode(".",basename($_FILES["notice_image"]["name"]));
				$file_ext = end($temp);

	    			// Insert image into images
	    			$new_image_stmt = $dbh->prepare("INSERT INTO Image (Img_Ref) Values(:img_ref)");
	    			$new_image_stmt->execute(array(":img_ref" => $file_ext));

	    			$image_id = $dbh->lastInsertId();

	    			// Set reference between notice id and image id
	    			$link_notice_image_stmt = $dbh->prepare("INSERT INTO NoticeImage (Img_Id,Notice_Id) Values (:img_id,:notice_id)");
	    			$link_notice_image_stmt->execute(array(":img_id" => $image_id,":notice_id" => $notice_id));


	    			// Upload image (name = Img_Id)

	    			// folder for uploaded images
		  		$target_dir = "user_images/";

		  		// Seperate's string at .
				$temp = explode(".",basename($_FILES["notice_image"]["name"]));

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
		  		if($_FILES["notice_image"]["size"] > 250000){
		  			echo "File size is too large";
		  			$uploadOk = 0;
		  		}

		  		// Try and upload file

		  		if($uploadOk == 0){
		  			echo "Sorry file was not uploaded";
		  		} else {
		  			if (move_uploaded_file($_FILES["notice_image"]["tmp_name"], $target_file)) {
					     // echo "The file ". basename( $_FILES["notice_image"]["name"]). " has been uploaded.";
					} else {
					     // echo "Sorry, there was an error uploading your file.";
					}
		  		}


	    		}
	    		else {
	    			echo "<div class='error_message'>Your notice was not submitted, please try again</div>";
	    		}

		}
		else {

			// Display error, user not allowed to make notice
			echo "<div class='error_message'>You must be logged in to create a notice</div>";
		}

	}

	?>
	<a href="add_notice.php">Add Notice</a>
    	<h1>All Notices</h1>

    	<table class="table full_width text_center">
    		<tr><th>Image</th><th>description</th><th>Edit</th></tr>
	<?php

		// Outputting all notices
		$all_notice_stmt = $dbh->prepare("Select * FROM Notice");
		$all_notice_stmt->execute();

		while($row = $all_notice_stmt->fetch()){
			// Get the image associated to this notice

			$notice_image_stmt = $dbh->prepare("Select * From Image Where Img_Id=(Select Img_Id From NoticeImage Where Notice_Id=:notice_id)");
			$notice_image_stmt->execute(array(":notice_id" => $row["Notice_Id"]));

			$image_row = $notice_image_stmt->fetch();
			$image_id  = $image_row["Img_Id"];

			echo "<tr><td><img src='user_images/". (String)$image_id . "." . $image_row["Img_Ref"] . "'/></td>"; 

			echo "<td>" . $row["Notice_Descrip"] . "</td>";

			echo "<td>";
			if(isset($_SESSION["Member_Id"])){
				if($row["Notice_MemberId"] == $_SESSION["Member_Id"]){
					echo "<a href='edit_notice.php?notice_id=" . $row["Notice_Id"] . "'>Edit</a>";
				}
			}
			echo "</td></tr>";
		}
	?>
	</table>
    </div>
    <div class="sideContent bgPrimary">
        <h1>Hello</h1>
        <p>Test</p>
    </div>

</div>
<!-- End of all Content -->

<!-- Footer Template -->
<?php include('template/footer.php'); ?>
<!-- End Footer Template -->


</body>
</html>


