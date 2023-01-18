<?php

    session_start();

    require __DIR__ . '/../assets/includes/session_authorization.php'; // loggedin, verified and null

    check_if_its_logged_in();

    session_unset();
    session_destroy();
    //session_write_close(); // not sure about this one
    //setcookie(session_name(),'',0,'/'); // not sure about this one
    //session_regenerate_id(true); // not sure about this one

    header("Location: ../login/");
    exit();

?>