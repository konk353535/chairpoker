<?php session_start() ?>
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

<div id="nav">
<ul>
  <li><a href="index.html">Home</a></li>
  <li><a href="events.html">Events</a></li>
  <li><a href="bulletin.html">Bulletin</a></li>
  <li><a href="artists.html">Artists</a></li>
  <li><a href="signUp.html">Sign Up</a></li>
  <li><a href="contact.html">Contact</a></li>
  <li><a href="userProfile.html">My Profile</a></li>
  <li><form><input type="search" class="navSearch" placeholder="Search">
  </form></li>
</ul>
</div>
<br>
<div id="main1">
  <h1>Log in</h1>
  <?php
    if(isset($_SESSION['errMsg']))
    {
      echo "<p>" . $_SESSION['errMsg'] . "</p>";
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
