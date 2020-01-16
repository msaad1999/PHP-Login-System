<?php

session_start();

require '../../assets/setup/env.php';
require '../../assets/setup/db.inc.php';
require '../../assets/includes/security_functions.php';

if (isset($_GET['selector']) && isset($_GET['validator'])) {

    /*
    * -------------------------------------------------------------------------------
    *   Securing against Header Injection
    * -------------------------------------------------------------------------------
    */

    foreach($_GET as $key => $value){

        $_GET[$key] = _cleaninjections(trim($value));
    }



    $selector = $_GET['selector'];
    $validator = $_GET['validator'];

    if (empty($selector) || empty($validator)) {

        $_SESSION['STATUS']['verify'] = 'invalid token, please use new verification email';
        header("Location: ../");
        exit();
    }

    $sql = "SELECT * FROM auth_tokens WHERE auth_type='account_verify' AND selector=? AND expires_at >= NOW() LIMIT 1;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {

        $_SESSION['ERRORS']['scripterror'] = 'SQL ERROR';
        header("Location: ../");
        exit();
    }
    else {

        mysqli_stmt_bind_param($stmt, "s", $selector);
        mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);

        if (!($row = mysqli_fetch_assoc($results))) {

            $_SESSION['STATUS']['verify'] = 'non-existent or expired token, please use new verification email';
            header("Location: ../");
            exit();
        }
        else {

            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row['token']);

            if ($tokenCheck === false) {

                $_SESSION['STATUS']['verify'] = 'invalid token, please use new verification email';
                header("Location: ../");
                exit();
            }
            else if ($tokenCheck === true) {

                $tokenEmail = $row['user_email'];

                $sql = 'SELECT * FROM users WHERE email=? LIMIT 1;';
                $stmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt, $sql)){

                    $_SESSION['ERRORS']['scripterror'] = 'SQL ERROR';
                    header("Location: ../");
                    exit();
                }
                else {

                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                    mysqli_stmt_execute($stmt);
                    $results = mysqli_stmt_get_result($stmt);

                    if (!$row = mysqli_fetch_assoc($results)) {
                        
                        $_SESSION['STATUS']['resentsend'] = 'invalid token, please use new verification email';
                        header("Location: ../");
                        exit();
                    }
                    else {

                        $sql = 'UPDATE users SET verified_at=NOW() WHERE email=?;';
                        $stmt = mysqli_stmt_init($conn);

                        if (!mysqli_stmt_prepare($stmt, $sql))
                        {
                            $_SESSION['ERRORS']['scripterror'] = 'SQL ERROR';
                            header("Location: ../");
                            exit();
                        }
                        else {

                            mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                            mysqli_stmt_execute($stmt);

                            $sql = "DELETE FROM auth_tokens WHERE user_email=? AND auth_type='account_verify';";
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql)){

                                $_SESSION['ERRORS']['scripterror'] = 'SQL ERROR';
                                header("Location: ../");
                                exit();
                            }
                            else {

                                mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                                mysqli_stmt_execute($stmt);
                                
                                if (isset($_SESSION['auth'])){

                                    $_SESSION['auth'] = 'verified';
                                }

                                $_SESSION['STATUS']['loginstatus'] = 'account activated, please login';
                                header ("Location: ../../login/");
                            }
                        }
                    }
                }
            }
        }
    }
}
else {

    header("Location: ../");
    exit();
}