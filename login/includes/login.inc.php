<?php

if (!isset($_POST['loginsubmit'])){

    header("Location: ../");
    exit();
}
else {

    require '../../assets/setup/db.inc.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {

        header("Location: ../?error=emptyfields");
        exit();
    } 
    else {

        $sql = "SELECT * FROM users WHERE username=?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {

            header("Location: ../?error=sqlerror");
            exit();
        } 
        else {

            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {

                $pwdCheck = password_verify($password, $row['password']);

                if ($pwdCheck == false) {

                    header("Location: ../?error=wrongpwd");
                    exit();
                } 
                else if ($pwdCheck == true) {

                    session_start();

                    $_SESSION['id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['full_name'] = $row['first_name'];
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

                    // var_dump($_SESSION);
                    // exit();

                    header("Location: ../../home/?login=success");
                    exit();
                } 
            } 
            else {

                header("Location: ../?error=nouser");
                exit();
            }
        }
    }
}