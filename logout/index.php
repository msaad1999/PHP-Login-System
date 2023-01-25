<?php

    session_start();

    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // or just
    // setcookie(session_name(),'',0,'/');
    // or maybe
    // setcookie(session_name(), '', 100);

    session_unset();
    session_destroy();

    header("Location: ../login/");
    exit();

?>