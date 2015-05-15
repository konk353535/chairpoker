<?php
	include("include/db_connect.php");
	var_dump($_POST);
    if(!isset($_POST['signUpForm'])){
        // probably here by accident, let's go somewhere more sensible
        header("Location: index.html");
       	exit();
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
                                    ":PasswordHash" => password_hash($_POST['Password1'], PASSWORD_DEFAULT),
                                    ":Fname" => $_POST['Fname'],
                                    ":Sname" => $_POST['Sname'],
                                    ":AuthLevelId" => 1));
    var_dump($new_member_statement->rowCount());
    if($new_member_statement->rowCount() > 0) {
        // successfully signed up, automatically sign in and direct to profile
        session_start();
        $_SESSION['Id'] = $dbh->lastInsertId();
        $_SESSION['Email'] = $_POST['Email'];
        $_SESSION['Name'] = $_POST['Fname'] . " " . $_POST['Sname'];
        
        session_regenerate_id();
       	header("Location: userProfile.php");
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