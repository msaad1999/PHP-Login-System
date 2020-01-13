<?php

function check_logged_in() {

    if (isset($_SESSION['auth'])){

        return true;
    }
    else {

        header("Location: ../login/");
        exit();
    }
}

function check_logged_in_butnot_verified(){

    if (isset($_SESSION['auth'])){

        if ($_SESSION['auth'] == 'loggedin') {
    
            return true;
        }
        elseif ($_SESSION['auth'] == 'verified') {

            header("Location: ../home/");
            exit(); 
        }
    }
    else {

        header("Location: ../login/");
        exit();
    }
}

function check_logged_out() {

    if (!isset($_SESSION['auth'])){

        return true;
    }
    else {

        header("Location: ../home/");
        exit();
    }
}

function check_verified() {

    if (isset($_SESSION['auth'])) {

        if ($_SESSION['auth'] == 'verified') {

            return true;
        }
        elseif ($_SESSION['auth'] == 'loggedin') {

            header("Location: ../verify/");
            exit(); 
        }
    }
    else {

        header("Location: ../login/");
        exit();
    }
}