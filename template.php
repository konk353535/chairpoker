<?php session_start(); 
$uri = $_SERVER['REQUEST_URI'];
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Townsville Community Music Centre</title>
    <link href="mainstyle.css" rel="stylesheet" type="text/css">
</head>

<body>

<div id="wrapper">
    <div id="header">
		<?php
			//check if logged in
			if(isset($_SESSION['Member_Id'])){
		?>
		<!-- unsure how to style this -->
		<div class="loginForm">
			<form id="form1" name="form1" method="post" action="login/logout.php?redirect=<?php echo $uri; ?>">
				<a href="userProfile.php">My Profile</a>
				<input type="submit" name="logout" value="Log Out" class="input"><br />
			</form>
		</div>
		<?php
			}
			// if not logged in
			else {
		?>
		<div class="loginForm">
            <form id="form1" name="form1" method="post" action="login/loginAuth.php?redirect=../userProfile.php&redirectFailure=<?php echo $uri; ?>">
                <input name="Email" type="text" id="textfield" placeholder="Email" class="input"><br />
                <input name="password" type="password" id="password" placeholder="********" class="input"><br />
                <input type="submit" name="loginForm" id="button" value="Log In" class="input"><br />
                <a href="signUp.html">Not a Member? </a>
            </form>
        </div>	
		<?php
			}
			if(isset($_SESSION['errMsg'])){
				echo "<p>" . $_SESSION['errMsg'] . "</p>";	
			}
		?>
        <div class="headerImage">
            <a href="index.html">
                <img src="images/TCMC150100.jpg" width="150" height="100" alt="Townsville Community Music Centre"/>
            </a>
        </div>
        <div class="headerWords">
            <span class="banner">
                Townsvile Community Music Centre
            </span> 
        </div>
    </div>
</div>
<div id="wrapper">
    <div class="bg-navbar">
        <div class="navbar">
            <!-- Comments from one li to the other is a workaround for an issue i was having with small spaces between my navigation bars -->
            <ul>
                 <li><a href="index.html">Home</a></li><!--
            --><li><a href="joinus.html">Join Us</a></li><!--
            --><li><a href="about_volleyball.html">About Volleyball</a></li><!--
            --><li><a href="contact_us.html">Contact Us</a></li><!--
            --><li><a href="announcements.html">Announcements</a></li><!--
            --><li><a href="ranks.html">Ranks</a></li>
            </ul>
        </div>    
    </div>
</div>
<!--
<div id="wrapper">
    <div class="navbar">
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="events.html">Events</a></li>
          <li><a href="bulletin.html">Bulletin</a></li>
          <li><a href="artists.html">Artists</a></li>
          <li><a href="signUp.html">Sign Up</a></li>
          <li><a href="contact.html">Contact</a></li>
          <li><a href="userProfile.html">My Profile</a></li>
          <!--<li><form><input type="search" class="navSearch" placeholder="Search"></form></li>
        </ul>
    </div>
</div>
-->
<div id="wrapper">
    <div class="mainContent">
      <h1>Main1 Header1  </h1>
      <p>Main1 p text. </p>
    </div>
    <div class="sideContent">
        <h1>Main2 Header1</h1>
        <p>Main2 p text. </p>
    </div>
</div>


<div id="wrapper">
    <div id="footer">
    Footer Content 
    </div>
</div>


</body>
</html>
