<?php

session_start();

require '..\assets\setup\env.php';
require '..\assets\setup\db.inc.php';
require '..\assets\includes\auth_functions.php';

check_remember_me();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo TITLE . ' | ' . APP_NAME; ?></title>

    <link rel="stylesheet" href="../assets/vendor/bootstrap-4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/fontawesome-5.12.0/css/all.min.css">
 
    <!-- Custom styles -->
    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="stylesheet" href="custom.css" >

</head>

<body>

    <?php require 'navbar.php'; ?>