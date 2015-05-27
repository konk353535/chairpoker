<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Townsville Community Music Centre</title>
<link href="mainstyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
    function input_validate_update_member(){
        var messages = "";
        if(document.getElementById("Member_Fname").value.trim() === ""){
            messages += "Please enter a First name.<br/>";
        }
        if(document.getElementById("Member_Sname").value.trim() === ""){
            messages += "Please enter a Surnname.<br/>";
        }
        if(document.getElementById("Member_Email").value.trim() === ""){
            messages += "Please enter an Email address.<br/>";
        }
        if(messages !== ""){
            document.getElementById("errorOutput").hidden = false;
            document.getElementById("errorOutput").innerHTML = messages.trim();
            return false;
        }
        return true;
    }
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
			else if(isset($_GET['Member_Id'])){
				include('db_connect.php');
				$memberStatement = $dbh->prepare('SELECT * FROM Member WHERE Member_Id = ?');
				$memberStatement->execute(array($_GET['Member_Id']));
				$member = $memberStatement->fetch();
		?>
			<form id='editMemberForm' method='post' action='adminMemberEditProcess.php' onsubmit="return input_validate_update_member()">
				<label class='label' for='Member_Fname'>First name:</label>
				<input class='block' type='text' id='Member_Fname' name='Member_Fname' value='<?php echo $member['Member_Fname'] ?>'>
				<label class='label' for='Member_Sname'>Surname:</label>
				<input class='block' type='text' id='Member_Sname' name='Member_Sname' value='<?php echo $member['Member_Sname'] ?>'>
				<label class='label' for='Member_Email'>Email:</label>
				<input class='block' type='text' id='Member_Email' name='Member_Email' value='<?php echo $member['Member_Email'] ?>'>
				<label class='label' for='Member_AuthLevel'>Authorisation level:</label>
				<select class='block' name='Member_AuthLevel'>
					<option value='1' <?php if($member['Member_AuthLevelId'] == 1){ echo "selected"; }?> >Regular</option>
					<option value='2' <?php if($member['Member_AuthLevelId'] == 2){ echo "selected"; }?> >Paid</option>
					<option value='3' <?php if($member['Member_AuthLevelId'] == 3){ echo "selected"; }?> >Admin</option>
				</select>
				<input type='text' name='Member_Id' value='<?php echo $_GET['Member_Id']; ?>' hidden>
				<input type='text' name='NumberOfCategories' id='NumberOfCategories' value='1' hidden>
				<input type='button' id='addNewCategory' value='additional category'>
				<input type='submit' name='editMemberForm' value='Confirm Changes'>
			</form>
			<div id='errorOutput' class='error_message' hidden></div>
		<?php
				
			} else {
                echo "<div class='error_message'>You are probably here by accident.  Oops! <a href='adminMemberList>'>click here</a> to go somewhere more sensible.</div>";
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
