<?php

    session_start();

    if (isset($_SESSION['authorization'])) {
    
        if (time() > $_SESSION['expire']) {
        
            session_unset();
            session_destroy();
        
            echo 'logged_out';
    
        }

    }

?>