<?php include("../include/db_connect.php"); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Townsville Community Music Centre</title>
<link href="../mainstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="wrapper">

<div id="header">
<form id="form1" name="loginForm" method="post">
  <p>
    <input name="textfield" type="text" id="textfield" placeholder="Username">
    </p>
  <p>
    <input name="password" type="password" id="password" placeholder="********">
  </p>
  <p>
    <input type="button" name="button" id="button" value="Button">
  </p>
  <a href="signUp.html">Not a Member? </a><br>
  
</form>
  <p><a href="index.html"><img src="TCMC Images Docs/SiteImages/TCMC150100.jpg" width="150" height="100" alt="Townsville Community Music Centre"/></a><span class="banner">Townsvile Community Music Centre</span>  </p>
</div>

<?php include("../include/inc_nav.php"); ?>
<br>
<div id="main1">
  <h1>Sign Up  </h1>
  <?php
  	if(isset($_SESSION['errMsg'])){
		echo "<p>" . $_SESSION['errMsg'] . "</p>";
	}
  ?>
  <!-- Needs styles -->
  <form name="signUpForm" method="post" action="addMember.php?redirectFail=signUp.php">
  <label for='Fname'>First name:</label>
  <input type='text' name='Fname'>
  <br/>
  <label for='Sname'>Last name:</label>
  <input type='text' name='Sname'>
  <br/>
  <label for='Email'>Email Address:</label>
  <input type='text' name='Email'>
  <br/>
  <label for='Password1'>Password:</label>
  <input type='password' name='Password1'>
  <br/>
  <label for='Password2'>Confirm Password:</label>
  <input type='password' name='Password2'>
  <br/>
  <input type='submit' name='signUpForm' value='sign up!' >
  </form>
</div>

<div id="main2">
<h1>Main2 Header1</h1>
<p>Main2 p text. </p>
</div>

<div id="footer">
footer 
</div>
</div>
</body>
</html>
