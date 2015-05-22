<?php session_start(); ?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Townsville Community Music Centre</title>
	<link href="mainstyle.css" rel="stylesheet" type="text/css">

	<!-- Google Fonts Open Sans -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

	<!-- Date Picker -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script>
	$(function(){
		$("#experiation_date").datepicker();
	});
	</script>
	<script>
		window.onload = function(){
			
		}
		function input_validate_member(){
			var messages = "";
			if(document.getElementById("Email").value.trim() === ""){
				messages += "Please enter an email address.<br/>";
			}
			if(document.getElementById("Fname").value.trim() === ""){
				messages += "Please enter a first name.<br/>";
			}
			if(document.getElementById("Sname").value.trim() === ""){
				messages += "Please enter a surname.<br/>";
			}
			if(document.getElementById("Password").value === ""){
				messages += "Please enter a Password.<br/>";
			}
			if(document.getElementById("ConfirmPassword").value === ""){
				messages += "Please confirm your password by typing it again<br/>";
			}
			else if(document.getElementById("Password").value !== document.getElementById("ConfirmPassword").value){
				messages += "Account Password and Confirm Password do not match<br/>";
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
<?php include('include/header.php'); ?>
<!-- End of header (Logo/LoginForm/TextTitle) -->

<!-- Nav Bar -->
<?php include('include/inc_nav.php'); ?>

<!-- All Content -->
<div class="allContent">
    <div class="mainContent bgPrimary">
    <!-- Main Content Here -->
      <h1>Sign up Today:</h1>
		<!-- needs styling to format -->
		<form id="signUpForm" method="post" action="signup/addMember.php?redirectFail=signUp.php" onsubmit="return input_validate_member()">
			<label for="Email">Email Address:</label>
			<input type="text" name="Email" id="Email">
			<label for="Fname">First Name(s):</label>
			<input type="text" name="Fname" id="Fname">
			<label for="Sname">Surname:</label>
			<input type="text" name="Sname" id="Sname">
			<label for="Password">Account Password:</label>
			<input type="password" name="Password" id="Password">
			<label for="ConfirmPassword">Confirm Password:</label>
			<input type="password" name="ConfirmPassword" id="ConfirmPassword">
			<input type="submit" name="signUpForm" value="Sign up">
		</form>
	<div id="errorOutput" class="error_message" hidden></div>
    <!-- End of Main Content -->

    </div>
    <div class="sideContent bgPrimary">
        <h1>Hello</h1>
        <p>Test</p>
    </div>

</div>
<!-- End of all Content -->

<!-- Footer Template -->

<div class="wrapper bgPrimary">
    <div class="footer">
        Footer Content 
    </div>
</div>

<!-- End Footer Template -->

</body>
</html>