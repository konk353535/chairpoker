<?php
	// enum to refer to user types
	session_start();
	UserType extends SplEnum {
		const REGULAR = 1;
		const PAID = 2;
		const ADMIN = 3;
	}
	
	// these functions assume that values in $_SESSION are set
	function authenticate_user_is($req_usertype){
		return $req_usertype == $_SESSION['AuthLevel'];
	}

	function authenticate_user_at_least($req_usertype){
		return $req_usertype >= $_SESSION['AuthLevel'];
	}

?>