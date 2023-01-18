<?php

    require 'db.php';

    mysqli_report(MYSQLI_REPORT_STRICT);

    //$conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    //if (!$conn)
    //{
    //    die("Connection failed: ". mysqli_connect_error());
    //}

    try {

        $conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        
    } catch (Exception $e) {

        echo "".$e->getCode();
        /* return 2 = Database Connection refused */
        //echo "2";

        exit;
        
    }

?>