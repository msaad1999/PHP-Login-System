<?php
    session_start();
    define('TITLE',"My Profile | Franklin's Fine Dining");

    $companyName = "Franklin's Fine Dining";
    include 'includes/arrays.php';
    
    if (!isset($_SESSION['userId']))
    {
        header("Location: index.php");
        exit();
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
        
        
        <div class="wrapper">
            <div id="banner">
                <img src="img/banner.png">
            </div>
            
            <div id="nav">
                    <?php include 'includes/nav.php'; ?>
            </div>
            
            
            
            <div class="content">
                
                <h1><?php echo $_SESSION['userUid'] ?></h1>
                
                <p><?php 
                if ($_SESSION['gender'] == 'm')
                {
                    echo 'Male';
                }
                else if ($_SESSION['gender'] == 'f')
                {
                    echo 'Female';
                }
                ?></p>
                
                <h3><?php echo $_SESSION['headline']; ?></h3>
                <h5><?php echo $_SESSION['bio']; ?></h5> 
                
                
                
                
                
                
<?php include 'includes/footer.php'; ?> 


                