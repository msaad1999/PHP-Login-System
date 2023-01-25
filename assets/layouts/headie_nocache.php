<?php

    session_start();

    require __DIR__ . '/../setup/settings.php'; // app description and limits
    require __DIR__ . '/../includes/session_authorization.php'; // loggedin, verified and null
    require __DIR__ . '/../includes/security_functions.php'; // plus token functions

    $_SESSION['sess_time'] = time(); // Check IsActive .js and .php files for details

    _mktoken();
    //

?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="description" content="<?php echo APP_DESCRIPTION;  ?>">
        <meta name="author" content="<?php echo APP_OWNER;  ?>">
        <meta name="keywords" content="" />

        <!-- Un Cache -->
        <meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT"/>
        <meta http-equiv="pragma" content="no-cache" />        

        <title><?php echo APP_NAME . ' | ' . TITLE; ?></title>
        <link rel="icon" type="image/png" href="../assets/images/favicon.png">

        <link rel="stylesheet" href="../assets/vendor/bootstrap-5.0.2-dist/css/bootstrap.min.css">
        
        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

        <script src="../assets/vendor/js/jquery-3.4.1.min.js"></script>
        
        <!-- Custom styles -->
        <link rel="stylesheet" href="../assets/css/app.css">
        <link rel="stylesheet" href="custom.css">

    </head>

    <body>

        <?php 
            
            //require 'navbar.php';
        
        ?>
    
    <!-- /BODY -->

<!-- /HTML -->