<?php session_start() ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Townsville Community Music Centre</title>
<link href="mainstyle.css" rel="stylesheet" type="text/css">
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
    if(isset($_SESSION['errMsg']))
    {
      echo "<div class='error_output'>" . $_SESSION['errMsg'] . "</div>";
    }
  ?>
  <form name="loginForm" method="post" action="loginAuth.php?redirect=../userProfile.php&redirectFailure=loginPage.php">
  <p>
    <input name="Email" type="text" id="textfield" placeholder="Email address">
    </p>
  <p>
    <input name="password" type="password" id="password" placeholder="********">
  </p>
  <p>
    <input type="submit" name="loginForm" id="button" value="Log in">
  </p>
  </form>
	</div>
</div>
<div id="main2">
<h1>Main2 Header1</h1>
<p>Main2 p text. </p>
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
