<?php

    session_start();

    $companyName = "Franklin's Fine Dining";
    include 'includes/arrays.php';
    
    function strip_bad_chars( $input ){
        $output = preg_replace( "/[^a-zA-Z0-9_-]/", "", $input);
        return $output;
    }
?>  

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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
                echo 
                '<form method="post" action="includes/logout.inc.php" id="login-form">
                    <input type="submit" class="button next login" name="logout-submit" value="Logout">
                </form>';
            }
            else
            {
                echo 
                '<h1>login</h1>
                <form method="post" action="includes/login.inc.php" id="login-form">
                    <input type="text" id="name" name="mailuid" placeholder="Username...">
                    <input type="password" id="password" name="pwd" placeholder="Password...">
                    <input type="submit" class="button next login" name="login-submit" value="Login">
                </form>
                <a href="signup.php" class="button previous">Signup</a>';
            }
        ?>
        
        <?php
            if (isset($_SESSION['userId']))
            {
                echo '<p class="open"> you are logged in</p><br>'
                . '<h3>USER: '.$_SESSION['userUid']."</h3>";
            }
            else
            {
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
                

                