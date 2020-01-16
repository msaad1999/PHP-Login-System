<?php

session_start();

require '../assets/includes/auth_functions.php';
check_logged_in();



if(isset($_COOKIE[session_name()])){

    setcookie(session_name(), '', time()-7000000, '/');
}

if(isset($_COOKIE['rememberme'])) {

    setcookie('rememberme', '', time()-7000000, '/');
    
    require '../assets/setup/db.inc.php';
    $sql = "DELETE FROM auth_tokens WHERE user_email=? AND auth_type='remember_me';";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)){

        mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
        mysqli_stmt_execute($stmt);
        
        if (isset($_SESSION['auth'])){

            $_SESSION['auth'] = 'verified';
        }
    }
}

session_unset();
session_destroy();

header("Location: ../login/");
exit();



