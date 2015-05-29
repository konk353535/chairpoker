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
				$members = $dbh->query("SELECT * FROM Member");
				echo "<table id='member_list' class='adminControlTable'>\n
						<tr><th>First name</th><th>Surname</th><th>Email Address</th><th>Registration Level</th></tr>\n";
				while($row = $members->fetch()){
                    $reg_level_name = "";
                    switch($row['Member_AuthLevelId']){
                        case 1:
                            $reg_level_name = "Regular";
                            break;
                        case 2:
                            $reg_level_name = "Paid";
                            break;
                        case 3:
                            $reg_level_name = "Admin";
                    }
		?>
					<tr id='Member<?php echo $row['Member_Id']?>'>
						<td name='row_Fname'><?php echo $row['Member_Fname'] ?></td>
						<td name='row_Sname'><?php echo $row['Member_Sname'] ?></td>
						<td name='row_Email'><?php echo $row['Member_Email'] ?></td>
						<td name='row_Mobile'><?php echo $reg_level_name ?></td>
						<td ><a class='styledLink' href='adminMemberEdit.php?Member_Id=<?php echo $row['Member_Id']?>'>Edit</a>|<a class='styledLink' href='admin_delete_member.php?member_id=<?php echo $row['Member_Id']; ?>'>Delete</a></td>
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
