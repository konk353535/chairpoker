<!-- Nav Bar -->
<div class="wrapper">
    <div class="bg-navbar">
        <div class="navbar">
			<?php 
			//retrieving script name via chopping off everything before "/" for compatibility
			$pageName = ltrim(substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/")), "/");
			?>
            <!-- Comments from one li to the other is a workaround for an issue i was having with small spaces between my navigation bars -->
            <ul>
				<li><a <?php if($pageName === 'index.php'){ echo "class='navbarSelected' "; } ?> href="index.php">Home</a></li><!--
            --><li><a <?php if($pageName === ''){ echo "class='navbarSelected' "; } ?> href="events.php">Events</a></li><!--
            --><li><a <?php if($pageName === 'notices.php'){ echo "class='navbarSelected' "; } ?> href="notices.php">Notices</a></li><!--
            --><li><a <?php if($pageName === ''){ echo "class='navbarSelected' "; } ?> href="">Artists</a></li><!--
            	<?php
					if(!isset($_SESSION['AuthLevel'])){
				?>
				--><li><a <?php if($pageName === 'signUp.php'){ echo "class='navbarSelected' "; }?> href="signUp.php">Sign Up</a></li><!--
				<?php
					} else {
				?>
				--><li><a <?php if($pageName === 'user_profile.php'){ echo "class='navbarSelected' "; }?> href="user_profile.php">Profile</a></li><!--
				<?php
					}
				?>	
            --><li><a <?php if($pageName === ''){ echo "class='navbarSelected' "; }?> href="contact.php">Contact</a></li>
            </ul>
        </div>    
    </div>
</div>