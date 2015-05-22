<!-- Logo + Login Form + Text Title -->
<div class="wrapper bgPrimary">
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
		<?php } ?>
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
