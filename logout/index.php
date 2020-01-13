<?php

session_start();

require '../assets/includes/auth_functions.php';
check_logged_in();

session_unset();
session_destroy();

header("Location: ../login/");
exit();



