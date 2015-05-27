<?php
	session_start();
	include("db_connect.php");
    if(!isset($_POST['signUpForm'])){
        // probably here by accident, let's go somewhere more sensible
        header("Location: index.html");
       	exit();
    }

	// verify that this email is not already in the database
	$all_member_emails = $dbh->query("SELECT Member_Email FROM Member");
	while($row = $all_member_emails->fetch())
	{
		if($_POST['Email'] == $row['Member_Email'])
		{
			// email already exists
			$_SESSION['errMsg'] = "That email is already in use by another member.";
			header("Location: " . $_GET['redirectFail']);
			exit();
		}
	}
    $new_member_statement = $dbh->prepare("INSERT INTO Member (Member_Email, Member_PasswordHash, Member_Fname, 
                                            Member_Sname, Member_AuthLevelId) VALUES(
                                            :Email ,
                                            :PasswordHash ,
                                            :Fname ,
                                            :Sname ,
                                            :AuthLevelId)");
    $new_member_statement->execute(array(
                                    ":Email" => $_POST['Email'],
                                    ":PasswordHash" => md5($_POST['Password']),
                                    ":Fname" => $_POST['Fname'],
                                    ":Sname" => $_POST['Sname'],
                                    ":AuthLevelId" => 1));
    if($new_member_statement->rowCount() > 0) {
        // successfully signed up, automatically sign in and direct to profile
        session_regenerate_id();
        $_SESSION['Member_Id'] = $dbh->lastInsertId();
        $_SESSION['Name'] = $_POST['Fname'] . " " . $_POST['Sname'];
		$_SESSION['AuthLevel'] = 1;
        
       	header("Location: user_profile.php");
        exit();
    }
    else {
        $_SESSION['errMsg'] = "An error occurred.  Sorry I couldn't be more helpful.";
        if(isset($_GET['redirectFail'])){
            header("Location: " . $_GET['redirectFail']);
        }
        else{
            header("Location: signUp.php?redirectFail=signUp.php");
        }
		exit();
    }

?>