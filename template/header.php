<!-- Logo + Login Form + Text Title -->
<div class="wrapper bgPrimary">
    <div id="header">
		<?php
			// primary session_start() call, should be high enough to do everything we need
			session_start();
			$uri = $_SERVER['SCRIPT_NAME'];
			//check if logged in
			if(isset($_SESSION['Name'])){
		?>
		<!-- unsure how to style this -->
		<div class="loginForm">
			<span><?php echo $_SESSION['Name']; ?></span>
			<form id="form1" name="form1" method="post" action="logout.php?redirect=<?php echo $uri; ?>">
				<a class="styledLink" href="user_profile.php">My Profile</a>
				<div style="text-align:center">
					<input type="submit" name="logout" value="Log Out" class="input"><br />
				</div>
			</form>
		</div>
		<?php
			}
			// if not logged in
			else {
		?>
		<div class="loginForm">
            <form id="form1" name="form1" method="post" action="loginAuth.php?redirect=<?php echo $uri; ?>&redirectFailure=<?php echo $uri; ?>">
                <input name="Email" type="text" id="textfield" placeholder="Email" class="input">
                <input name="password" type="password" id="password" placeholder="********" class="input">
                <input type="submit" name="loginForm" id="button" value="Log In" class="input">
                <a href="signUp.php">Not a Member? </a>
            </form>
        </div>
		<?php } ?>
        <div class="headerImage">
            <a href="index.php">
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
