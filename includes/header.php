<?php

    session_start();
    include_once 'dbh.inc.php';

    $companyName = "Franklin's Fine Dining";
    include 'includes/arrays.php';
    
    function strip_bad_chars( $input ){
        $output = preg_replace( "/[^a-zA-Z0-9_-]/", "", $input);
        return $output;
    }
?>  

<!DOCTYPE html>

<html>
    <head>
        <title><?php echo TITLE; ?></title>
        <link href="includes/styles.css" rel="stylesheet"> 
        <link rel="shortcut icon" href="img/logo.ico" />
    </head>
    <body id="final-example">
        
    <!-------     LOGIN / LOGOUT FORM               --------->
        
    <div id="login">
    
        
        <?php 
            
            if(isset($_SESSION['userId']))
            {
                echo'<img id="userDp" src=./uploads/'.$_SESSION["userImg"].'>
                <h3>' . strtoupper($_SESSION['userUid']) . '</h3>
                <a href="profile.php" class="button login">My Profile</a>
                <form method="post" action="includes/logout.inc.php" id="login-form">
                    <input type="submit" class="button next login" name="logout-submit" value="Logout">
                </form>';
                
                echo '<h5 class="open"> you are logged in</h5><br>';
            }
            else
            {
                echo '<h1>Login</h1>';
                
                
                if(isset($_GET['error']))
                {
                    if($_GET['error'] == 'emptyfields')
                    {
                        echo '<p class="closed">*please fill in all the fields</p>';
                    }
                    else if($_GET['error'] == 'nouser')
                    {
                        echo '<p class="closed">*username does not exist</p>';
                    }
                    else if ($_GET['error'] == 'wrongpwd')
                    {
                        echo '<p class="closed">*wrong password</p>';
                    }
                    else if ($_GET['error'] == 'sqlerror')
                    {
                        echo '<p class="closed">*website error. contact admint to have it fixed</p>';
                    }
                }

                echo '<form method="post" action="includes/login.inc.php" id="login-form">
                    <input type="text" id="name" name="mailuid" placeholder="Username...">
                    <input type="password" id="password" name="pwd" placeholder="Password...">
                    <input type="submit" class="button next login" name="login-submit" value="Login">
                </form>
                <a href="signup.php" class="button previous">Signup</a>';
                
                echo '<p class="closed"> you are logged out</p>';
                
            }
        ?>

    </div>
    
    <!-------     LOGIN / LOGOUT FORM END           --------->
        
        
        <div class="wrapper">
            <div id="banner">
                <img src="img/banner.png">
            </div>
            
            <div id="nav">
                    <?php include 'includes/nav.php'; ?>
                
                
            </div>
            
            
            
            <div class="content">
                

                