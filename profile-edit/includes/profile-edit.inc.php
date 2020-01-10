<?php
session_start();

if (isset($_POST['update-profile'])) {

    require '../../assets/setup/db.inc.php';
    require '../../assets/includes/datacheck.php';

    $username = $_POST['username'];
    $email = $_POST['email'];
    $first_name = $_POST['firstl_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $headline = $_POST['headline'];
    $bio = $_POST['bio'];

    $oldPassword = $_POST['password'];
    $newpassword = $_POST['newpassword'];
    $passwordrepeat  = $_POST['confirmpassword'];


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        header("Location: ../?error=invalidmail");
        exit();
    } 
    if ($_SESSION['email'] != $email && !availableEmail($conn, $email)) {

        header("Location: ../?error=emailtaken");
        exit();
    }
    if ( $_SESSION['username'] != $username && !availableUsername($conn, $username)) {

        header("Location: ../?error=usernametaken");
        exit();
    }
    else {

        /*
        * -------------------------------------------------------------------------------
        *   Password Updation
        * -------------------------------------------------------------------------------
        */

        if( !empty($oldPassword) || !empty($newpassword) || !empty($passwordRepeat)){

            require 'password-edit.inc.php';
        }  


        /*
        * -------------------------------------------------------------------------------
        *   Image Upload
        * -------------------------------------------------------------------------------
        */

        $FileNameNew = $_SESSION['profile_image'];
        $file = $_FILES['avatar'];

        if (!empty($_FILES['avatar']['name']))
        {
            $fileName = $_FILES['avatar']['name'];
            $fileTmpName = $_FILES['avatar']['tmp_name'];
            $fileSize = $_FILES['avatar']['size'];
            $fileError = $_FILES['avatar']['error'];
            $fileType = $_FILES['avatar']['type']; 

            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));

            $allowed = array('jpg', 'jpeg', 'png', 'gif');
            if (in_array($fileActualExt, $allowed))
            {
                if ($fileError === 0)
                {
                    if ($fileSize < 10000000)
                    {
                        $FileNameNew = uniqid('', true) . "." . $fileActualExt;
                        $fileDestination = '../../assets/uploads/users/' . $FileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination);

                    }
                    else
                    {
                        header("Location: ..?error=imgsizeexceeded");
                        exit(); 
                    }
                }
                else
                {
                    header("Location: ../?error=imguploaderror");
                    exit();
                }
            }
            else
            {
                header("Location: ../?error=invalidimagetype");
                exit();
            }
        }


        /*
        * -------------------------------------------------------------------------------
        *   User Updation
        * -------------------------------------------------------------------------------
        */

        $sql = "UPDATE users 
            SET username=?,
            email=?, 
            first_name=?, 
            last_name=?, 
            gender=?, 
            headline=?, 
            bio=?, 
            profile_image=?,";

        if ($pwdChange){

            $sql .= "password=? 
                    WHERE id=?;";
        }
        else{

            $sql .= "WHERE id=?;";
        }

        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../?error=sqlerror");
            exit();
        } else {

            if ($pwdChange){

                $hashedPwd = password_hash($newpassword, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "ssssssssss", 
                    $username,
                    $email,
                    $first_name,
                    $last_name,
                    $gender,
                    $headline,
                    $bio,
                    $FileNameNew,
                    $hashedPwd,
                    $_SESSION['id']
                );
            }
            else{

                mysqli_stmt_bind_param($stmt, "sssssssss", 
                    $username,
                    $email,
                    $first_name,
                    $last_name,
                    $gender,
                    $headline,
                    $bio,
                    $FileNameNew,
                    $_SESSION['id']
                );
            }

            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['last_name'] = $last_name;
            $_SESSION['gender'] = $gender;
            $_SESSION['headline'] = $headline;
            $_SESSION['bio'] = $bio;
            $_SESSION['profile_image'] = $FileNameNew;

            header("Location: ../?edit=success");
            exit();
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} 
else {

    header("Location: ../");
    exit();
}
