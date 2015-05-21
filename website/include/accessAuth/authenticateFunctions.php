<?php
	// enum to refer to user types
	session_start();
	UserType extends SplEnum {
		const REGULAR = 1;
		const PAID = 2;
		const ADMIN = 3;
	}
	

	function authenticate_user_is($req_usertype, $redirect_on_fail){
		if(!isset($_SESSION['AuthLevelId'])){
			// not logged in
			header("Location: " . $redirect_on_fail);			
		}
		if($_SESSION['AuthLevelId'] != $req_usertype){
			header("Location: " . $redirect_on_fail);
		}
		// do nothing if logged in as appropriate user
	}

	function authenticate_user_at_least($req_usertype, $redirect_on_fail){
		if(!isset($_SESSION['AuthLevelId'])){
			// not logged in
			header("Location: " . $redirect_on_fail);			
		}
		if($_SESSION['AuthLevelId'] < $req_usertype){
			header("Location: http://" . $_SERVER['HTTP_HOST'] . $redirect_on_fail);
		}
		// do nothing if logged in as appropriate user
	}

?>