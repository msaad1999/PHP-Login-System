<?php

    //define("MLS_ROOT", dirname(dirname(__FILE__))); // this was replacesd by __DIR__ in PHP 5.3
    //echo MLS_ROOT;

    //echo ini_get('session.cookie_domain');

    //session_start();
    //unset($_SESSION['teta']);

    $email = 'rodka@shopperbr.com';
    $dominio = substr($email, strpos($email, '@') + 1);
    echo $dominio . "</br></br>";

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // Invalid email

        $domain = substr($email, strpos($email, '@') + 1);

        if (!checkdnsrr($domain, 'MX')) {

            echo 'Email inválido';

        }

        echo 'Email Válido';
        
    } else {

        echo 'Email inválido';

    }

    $d1="rodkarodkarodka.con";
    $d2="rodkarodkarodka.con.";
    $d3="rodkarodkarodka.com";
    $d4="rodkarodkarodka.com.";
    
    if (checkdnsrr($d1, "MX")) {

        echo "gmail.con" . $r1 . " is valid</br></br>";

    }

    if (checkdnsrr($d2, "MX")) {

        echo "gmail.con." . $r2 . " is valid</br></br>";

    }

    if (checkdnsrr($d3, "MX")) {

        echo "gmail.com" . $r3 . " is valid</br></br>";

    }

    if (checkdnsrr($d4, "MX")) {

        echo "gmail.com." . $r4 . " is valid</br></br>";

    }


?>