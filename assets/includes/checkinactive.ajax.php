<?php
session_start();
if (isset($_SESSION['auth']) && !isset($_COOKIE['rememberme'])){
    if(time() > $_SESSION['expire']){
        session_unset();
        session_destroy();
        echo 'logout_redirect';
    }
}