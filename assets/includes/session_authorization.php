<?php

    // Session and authorization related

    function check_if_its_logged_in() {

        if (isset($_SESSION['authorization'])) { // if there is any authorization, RETURN TRUE

            return true;

        } else { // if there is NOT ANY authorization

            header("Location: ../login/"); // relative path
            //header("Location: /login/");

            exit();        

        }

    }

    function check_if_its_logged_out() { // 

        if (!isset($_SESSION['authorization'])) { // if there is NOT ANY authorization, RETURN TRUE

            return true;

        } else {

            header("Location: ../home/"); // if there is any authorization (also using relative path)
            //header("Location: /home/");
            exit();

        }

    }

    function check_if_its_logged_in_but_not_verified() {

        if (isset($_SESSION['authorization'])) { // if there is any authorization check if it's just logged in or if it's verified

            if ($_SESSION['authorization'] == 'loggedin') {

                return true;

            } elseif ($_SESSION['authorization'] == 'verified') {
                
                header("Location: ../home/"); // relative path
                //header("Location: /home/");
                exit();

            }

        } else {

            header("Location: ../login/"); // relative path
            //header("Location: " . $_SERVER['DOCUMENT_ROOT'] . "/login/");
            exit();

        }

    }

    function check_if_its_verified() {

        if (isset($_SESSION['authorization'])) { // if there is any authorization

            if ($_SESSION['authorization'] == 'verified') {

                return true;

            }
            elseif ($_SESSION['authorization'] == 'loggedin') {

                header("Location: ../verify/"); // relative path
                //header("Location: /verify/");
                exit(); 

            }

        } else {

            header("Location: ../login/"); // relative path
            //header("Location: /login/");
            exit();

        }

    }

    /*function do_login($email) {

        require '../assets/setup/db.inc.php';
        
        $sql = "SELECT * FROM usrs WHERE email=?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            
            return false;

        } else {
            
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if (!$row = mysqli_fetch_assoc($result)) {
                
                return false;

            } else {

                if($row['verified_at'] != NULL){

                    $_SESSION['auth'] = 'verified';

                } else {

                    $_SESSION['auth'] = 'loggedin';
                    
                }

                $_SESSION['id'] = $row['id'];
                $_SESSION['fullname'] = $row['fullname'];
                $_SESSION['email'] = $row['email'];
                //$_SESSION['gender'] = $row['gender'];
                //$_SESSION['headline'] = $row['headline'];
                //$_SESSION['bio'] = $row['bio'];
                //$_SESSION['profile_image'] = $row['profile_image'];
                //$_SESSION['banner_image'] = $row['banner_image'];
                //$_SESSION['user_level'] = $row['user_level'];
                //$_SESSION['verified_at'] = $row['verified_at'];
                //$_SESSION['created_at'] = $row['created_at'];
                //$_SESSION['updated_at'] = $row['updated_at'];
                //$_SESSION['deleted_at'] = $row['deleted_at'];
                //$_SESSION['last_login_at'] = $row['last_login_at'];
                
                return true;

            }

        }
        
    }*/

?>