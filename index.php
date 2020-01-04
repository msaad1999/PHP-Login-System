<?php

include 'assets/setup/db.inc.php';

if (!isset($_SESSION['userId'])) {

    header("Location: /home");
    exit();
}
else {

    header("Location: /login");
    exit();
}
