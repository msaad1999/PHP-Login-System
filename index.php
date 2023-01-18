<?php

    // IF there is some sort of authorization redirect accordingly
    if (isset($_SESSION['authorization'])) {

        header("Location: home"); // Home has its own IF to check if user is loggedin, verified or neither.
        exit();

    } else {

        header("Location: login"); // If there is no session variable called authorization send it to login
        exit();

    }

?>
