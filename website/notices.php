<?php

if($_GET['action'] == "new_notice"){
	// We have a new notice submittion

	// Authority to make notice?
	$auth_level = $_SESSION['AuthLevel'];

	if($auth_level >= 1){
		// User is registered, proceed

	}
	else {
		// Display error, user not allowed to make notice
	}


}


?>