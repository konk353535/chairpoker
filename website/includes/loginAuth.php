<?php
/* WORK IN PROGRESS*/
    /* this file is used as the target when the login form is submitted.  
        it is advised to set a variable called redirect in the url string 
        so the user is returned there when invalid password/emails are given 
    */
    session_start();
    include("db_connect.php");

    // if we're logged in already, do nothing
    if(!isset($_SESSION['Email']))
    {
        // if we got here from the site's login form, handle that
        if(isset($_POST['loginForm']))
        {
            $password_statement = $dbh->prepare("SELECT Member_Id, Member_PasswordHash FROM Member WHERE Member_Email = ?");
            $result = $password_statement->execute(array($_POST['Email']));
            $row = $result->fetch(PDO::FETCH_ASSOC);
            // verify that this email exists in the database
            // PDO::fetch returns false for some reason if the dataset is empty... checking for that here.  Short circuiting keeps code a little clean at least
            if($row === FALSE || md5($_POST['password']) != $row['Member_PasswordHash'])
            {
                $_SESSION['errMsg'] = "Invalid Email Address or Password";
                header("Location: " . $_GET['redirect']);
                exit();
            }
            $result = $dbh->query("SELECT Member_Fname, Member_Sname FROM Member WHERE Member_Id = " . $row['Member_Id']);
            $row = $result->fetch();
            $first_name = $row['Member_Fname'];
            $last_name = $row['Member_Sname'];

            $_SESSION['Email'] = $_POST['Email'];
            $_SESSION['Name'] = $first_name . " " . $last_name;

            session_regenerate_id();
            
            
        }
        
    }
?>