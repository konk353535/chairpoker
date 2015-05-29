<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Townsville Community Music Centre</title>
<link href="mainstyle.css" rel="stylesheet" type="text/css">
	<script type='text/javascript'>
		
	</script>
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
			if(!isset($_SESSION['AuthLevel']) || $_SESSION['AuthLevel'] != 3){
				echo "<div class='error_message'>You need to be logged in with administrator rights to access this resource</div>";
			}
			else {
				if(isset($_GET['success_message'])){
					echo "<div class='success_message'>" . $_GET['success_message'] . "</div>";
				}
				if(isset($_GET['error_message'])){
					echo "<div class='error_message'>" . $_GET['error_message'] . "</div>";
				}
				include('db_connect.php');
				$artists = $dbh->query("SELECT * FROM Artist");
				echo "<table class='adminControlTable'>\n
						<tr><th>First name</th><th>Surname</th><th>Email Address</th><th>Daytime Phone</th><th>Mobile Phone</th></tr>\n";
				while($row = $artists->fetch()){
		?>
					<tr id='Artist<?php echo $row['Artist_Id']?>'>
						<td name='row_Fname'><?php echo $row['Artist_Fnames'] ?></td>
						<td name='row_Sname'><?php echo $row['Artist_Sname'] ?></td>
						<td name='row_Email'><?php echo $row['Artist_Email'] ?></td>
						<td name='row_PhoneDay'><?php echo $row['Artist_PhoneDay'] ?></td>
						<td name='row_Mobile'><?php echo $row['Artist_Mobile'] ?></td>
						<td ><a class='styledLink' href='adminArtistEdit.php?Artist_Id=<?php echo $row['Artist_Id']?>'>Edit</a>|<a class='styledLnk' href='admin_delete_artist.php?artist_id=<?php echo $row['Artist_Id']?>'>delete</a></td>
					</tr>
		<?php
				}
				echo "</table>\n</form>";
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
