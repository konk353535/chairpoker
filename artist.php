




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
			if(!isset($_GET['artist_id'])){
				echo "<div class='error_message'>Oops, you're probably here by accident. <a href='artists.php'>ABORT</a></div>";
			} else {
				include("db_connect.php");
				$artist_id = $_GET['artist_id'];
				$artist = $dbh->prepare("SELECT * FROM Artist WHERE Artist_Id = ?");
				$artist->execute(array($artist_id));
				$row = $artist->fetch();
				echo "<h1>" . $row['Artist_Fnames'] . " " . $row['Artist_Sname'] . "</h1>";
				$artist_image = $dbh->query("SELECT * FROM Image WHERE Img_Id = (Select Img_Id From ArtistImage WHERE Artist_Id = " . $row['Artist_Id'] . ")");
				$image_row = $artist_image->fetch();
				$image_id  = $image_row["Img_Id"];
				echo "<div class='artist_group'>";
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
				echo "<h3>Here are " . $row['Artist_Fnames'] . " " . $row['Artist_Sname'] . "'s contact details:</h3>";
				echo "<p>Daytime Phone Number: " . $row['Artist_PhoneDay'] . "</p>";
				echo "<p>Email Address: " . $row['Artist_Email'] . "</p>";
				echo "</div>";
			}
			
		?>
	</div>
</div>