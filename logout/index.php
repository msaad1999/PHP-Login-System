<?php

session_start();

require '../assets/includes/auth_functions.php';
check_logged_in();

session_unset();
session_destroy();

if(isset($_COOKIE[session_name()])):
    setcookie(session_name(), '', time()-7000000, '/');
endif;

if(isset($_COOKIE['rememberme'])):
    setcookie('rememberme', '', time()-7000000, '/');
endif;

header("Location: ../login/");
exit();



