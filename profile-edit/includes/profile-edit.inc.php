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

        $_SESSION['ERRORS']['emailerror'] = 'invalid email, try again';
        header("Location: ../");
        exit();
    } 
    if ($_SESSION['email'] != $email && !availableEmail($conn, $email)) {

        $_SESSION['ERRORS']['emailerror'] = 'email already taken';
        header("Location: ../");
        exit();
    }
    if ( $_SESSION['username'] != $username && !availableUsername($conn, $username)) {

        $_SESSION['ERRORS']['usernameerror'] = 'username already taken';
        header("Location: ../");
        exit();
    }
    else {

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
                        $_SESSION['ERRORS']['imageerror'] = 'image size should be less than 10MB';
                        header("Location: ../");
                        exit(); 
                    }
                }
                else
                {
                    $_SESSION['ERRORS']['imageerror'] = 'image upload failed, try again';
                    header("Location: ../");
                    exit();
                }
            }
            else
            {
                $_SESSION['ERRORS']['imageerror'] = 'invalid image type, try again';
                header("Location: ../");
                exit();
            }
        }


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
            profile_image=?";

        if ($pwdChange){

            $sql .= ", password=? 
                    WHERE id=?;";
        }
        else{

            $sql .= " WHERE id=?;";
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

            $_SESSION['STATUS']['editsuccess'] = 'profile successfully updated';
            header("Location: ../");
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
