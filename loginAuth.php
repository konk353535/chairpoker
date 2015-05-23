<?php
    /* this file is used as the target when the login form is submitted.  
        it is advised to set a variable called redirectFailure in the query string 
        so the user is returned there when invalid password/emails are given, and another called redirect
        for when they successfully log in
    */
	error_reporting(E_ALL);
    session_start();

    include("db_connect.php");
	
	// if we got here from the site's login form, handle that
	if(isset($_POST['loginForm']))
	{
		$credentials_statement = $dbh->prepare("SELECT Member_Id, Member_PasswordHash FROM Member WHERE Member_Email = ?");
		$credentials_statement->execute(array($_POST['Email']));
		$result = $credentials_statement->fetch();
		// verify that this email and a matching password exists in the database
		if($result === FALSE || md5($_POST['password']) !== $result['Member_PasswordHash'])
		{
			$_SESSION['errMsg'] = "Invalid Email Address or Password";
			if(isset($_GET['redirectFailure'])){
			//	header("Location: " . $_GET['redirectFailure']);
			}
			else {
			//	header("Location: ../index.html");
			}
			//exit();
		}
		
		$member_details = $dbh->query("SELECT Member_Id, Member_Fname, Member_Sname, Member_AuthLevelId FROM Member 
								WHERE Member_Id = " . $result['Member_Id'])->fetch();
		
		session_regenerate_id();
		$_SESSION['Member_Id'] = $member_details['Member_Id'];
		$_SESSION['Name'] = $member_details['Member_Fname'] . " " . $member_details['Member_Sname'];
		$_SESSION['AuthLevel'] = $member_details['Member_AuthLevelId'];
		unset($_SESSION['errMsg']);
		header("Location: " . $_GET['redirect']);
		exit();
	}
	else if(isset($_GET['redirectFailure'])){
		header("Location: " . $_GET['redirectFailure']);
	}
	else {
		header("Location: ../index.html");
	}
	exit();
        
?>
