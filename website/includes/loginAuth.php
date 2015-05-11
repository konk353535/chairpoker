<?php
/* WORK IN PROGRESS*/
    /* this file is used as the target when the login form is submitted.  
        it is advised to set a variable called redirect in the url string 
        so the user is returned there when invalid password/emails are given 
    */
    session_start();
    include("db_connect.php");

    // if we're logged in already, do nothing
    if(!isset($_SESSION['username']))
    {
        // if we got here from the site's login form, handle that
        if(isset($_POST['loginForm']))
        {
            $password_statement = $dbh->prepare("SELECT Member_Id, Member_PasswordHash FROM Member WHERE Member_Email = ?");
            $result = $password_statement->execute(array($_POST['Email']));
            // verify that this email exists in the database
            
            // I forget how this works, fix it later
            $row = $result->fetch();
            $member_id = $row['Member_Id'];
            $password_hash = $row['Member_PasswordHash'];
            if($password_hash == md5($_POST['password']))
            {
                $result = $dbh->query("SELECT Member_Fname, Member_Sname FROM Member WHERE Member_Id = " . $member_id);
                $row = $result->fetch();
                $first_name = $row['Member_Fname'];
                $last_name = $row['Member_Sname'];
                
                $_SESSION['Email'] = $_POST['Email'];
                $_SESSION['Name'] = $first_name . " " . $last_name;
            }
            else
            {
                // handle invalid password
                if(isset($_GET['redirect']))
                {
                    header("Location: " . $_GET['redirect']);
                    exit();
                }
            }
            
        }
        
    }
?>