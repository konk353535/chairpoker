<?php
	/* WORK IN PROGESS */
    /* this file is used as the target when the login form is submitted.  
        it is advised to set a variable called redirectFailure in the query string 
        so the user is returned there when invalid password/emails are given, and another called redirect
        for when they successfully log in
    */
    session_start();
    include("../include/db_connect.php");
	
	// if we got here from the site's login form, handle that
	if(isset($_POST['loginForm']))
	{
		$credentials_statement = $dbh->prepare("SELECT Member_Id, Member_PasswordHash FROM Member WHERE Member_Email = ?");
		$credentials_statement->execute(array($_POST['Email']));
		$result = $credentials_statement->fetch();
		// verify that this email and a matching password exists in the database
		if($result === FALSE || !password_verify($_POST['password'], $result['Member_PasswordHash']))
		{
			$_SESSION['errMsg'] = "Invalid Email Address or Password";
			if(isset($_GET['redirectFailure'])){
				header("Location: " . $_GET['redirectFailure']);
			}
			else {
				header("Location: ../index.html");
			}
			exit();
		}
		$result = $dbh->query("SELECT Member_Id, Member_Fname, Member_Sname FROM Member 
								WHERE Member_Id = " . $result['Member_Id'])->fetch();
		var_dump($result);
		session_regenerate_id();
		$_SESSION['Member_Id'] = $result['Member_Id'];
		$first_name = $result['Member_Fname'];
		$last_name = $result['Member_Sname'];
		$_SESSION['Email'] = $_POST['Email'];
		$_SESSION['Name'] = $first_name . " " . $last_name;
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