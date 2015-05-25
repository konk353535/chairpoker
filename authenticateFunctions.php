<?php
	
	// these functions assume that values in $_SESSION are set
	function authenticate_user_is($req_usertype){
		return $req_usertype == $_SESSION['AuthLevel'];
	}

	function authenticate_user_at_least($req_usertype){
		return $req_usertype >= $_SESSION['AuthLevel'];
	}

?>