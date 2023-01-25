<?php

    require __DIR__ . '/../setup/settings.php';

    if (!isset($_SESSION)) {

        session_start();

    }

    if (isset($_SESSION['authorization'])) {

        //$limit = 600; // 10 minutes
        $limit = INACTIVE_TIME_LIMIT;
        $stime = $_SESSION['sess_time'];

        $sess_timeout = time() - $stime; // current time minus session time

        if ($sess_timeout > $limit) {

            echo 'itisinactive_redirecttologin'; // echoing the response to AJAX

        }

    }

?>