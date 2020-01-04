<?php

session_start();
require '..\assets\setup\db.inc.php';

$companyName = "PHP Login/Registration System";
// include '..\assets\includes\arrays.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <!-- Custom styles for this template-->
    <link href="..\assets\css\app.css" rel="stylesheet">
    <link href="custom.css" rel="stylesheet">

</head>

<body>

    <?php require 'navbar.php'; ?>