<?php

    /* Helps with error messages returned to user and have fewer code lines */
    function errorExiting($suberror, $errormsg) {

        $_SESSION['ERRORS'][$suberror] = $errormsg;
        
        if (isset($_SESSION['authorization'])) {
            
            unset($_SESSION['authorization']);
        
        }
        
        header("Location: ../");
        exit();

    }

?>