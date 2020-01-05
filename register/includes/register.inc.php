<?php

if (isset($_POST['register']))
{
    
    require 'dbh.inc.php';
    
    
    $userName = $_POST['username'];
    $email = $_POST['mail'];
    $password = $_POST['password'];
    $passwordRepeat  = $_POST['confirmpassword'];
    $gender = $_POST['gender'];
    $headline = $_POST['headline'];
    $bio = $_POST['bio'];
    $f_name = $_POST['full-name'];
    $l_name = $_POST['last-name'];
    
    if (empty($userName) || empty($email) || empty($password) || empty($passwordRepeat))
    {
        header("Location: ../register/?error=emptyfields&uid=".$userName."&mail=".$email);
        exit();
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $userName))
    {
        header("Location: ../register/?error=invalidmailuid");
        exit();
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        header("Location: ../register/?error=invalidmail&uid=".$userName);
        exit();
    }
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $userName))
    {
        header("Location: ../register/?error=invaliduid&mail=".$email);
        exit();
    }
    else if ($password !== $passwordRepeat)
    {
        header("Location: ../register/?error=passwordcheck&uid=".$userName."&mail=".$email);
        exit();
    }
    else
    {
        // checking if a user already exists with the given username
        $sql = "select username from users where username=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("Location: ../register/?error=sqlerror");
            exit();
        }
        else
        {
            mysqli_stmt_bind_param($stmt, "s", $userName);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            
            $resultCheck = mysqli_stmt_num_rows($stmt);
            
            if ($resultCheck > 0)
            {
                header("Location: ../register/?error=usertaken&mail=".$email);
                exit();
            }
            else
            {
                $FileNameNew = 'default.png';
                require 'upload.inc.php';
                
                $sql = "insert into users(uidUsers, emailUsers, f_name, l_name, pwdUsers, gender, "
                        . "headline, bio, userImg) "
                        . "values (?,?,?,?,?,?,?,?,?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql))
                {
                    header("Location: ../register/?error=sqlerror");
                    exit();
                }
                else
                {
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                    
                    mysqli_stmt_bind_param($stmt, "sssssssss", $userName, $email, $f_name, $l_name,
                            $hashedPwd, $gender,
                            $headline, $bio, $FileNameNew);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    
                    header("Location: ../home/?signup=success");
                    exit();
                }
            }
        }
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
}

else
{
    header("Location: ../register/");
    exit();
}