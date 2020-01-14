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

function force_login($email) {

    require '../assets/setup/db.inc.php';
    
    $sql = "SELECT * FROM users WHERE email=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        
        return false;
    } 
    else {
        
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (!$row = mysqli_fetch_assoc($result)) {
            
            return false;
        }
        else {

            if($row['verified_at'] != NULL){

                $_SESSION['auth'] = 'verified';
            } else{

                $_SESSION['auth'] = 'loggedin';
            }

            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];
            $_SESSION['gender'] = $row['gender'];
            $_SESSION['headline'] = $row['headline'];
            $_SESSION['bio'] = $row['bio'];
            $_SESSION['profile_image'] = $row['profile_image'];
            $_SESSION['banner_image'] = $row['banner_image'];
            $_SESSION['user_level'] = $row['user_level'];
            $_SESSION['verified_at'] = $row['verified_at'];
            $_SESSION['created_at'] = $row['created_at'];
            $_SESSION['updated_at'] = $row['updated_at'];
            $_SESSION['deleted_at'] = $row['deleted_at'];
            $_SESSION['last_login_at'] = $row['last_login_at'];
            
            return true;
        }
    }
}

function check_remember_me() {

    

    require '../assets/setup/db.inc.php';
    
    if (empty($_SESSION['auth']) && !empty($_COOKIE['rememberme'])) {
        
        list($selector, $validator) = explode(':', $_COOKIE['rememberme']);

        $sql = "SELECT * FROM auth_tokens WHERE auth_type='remember_me' AND selector=? AND expires_at >= NOW() LIMIT 1;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {

            // SQL ERROR
            return false;
        }
        else {
            
            mysqli_stmt_bind_param($stmt, "s", $selector);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);

            if (!($row = mysqli_fetch_assoc($results))) {

                // COOKIE VALIDATION FAILURE
                return false;
            }
            else {

                $tokenBin = hex2bin($validator);
                $tokenCheck = password_verify($tokenBin, $row['token']);

                if ($tokenCheck === false) {

                    // COOKIE VALIDATION FAILURE
                    return false;
                }
                else if ($tokenCheck === true) {

                    $email = $row['user_email'];
                    force_login($email);
                    
                    return true;
                }
            }
        }
    }
}