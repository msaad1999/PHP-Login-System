<?php

if (isset($_POST['signup-submit']))
{
    
    require 'dbh.inc.php';
    
    
    $userName = $_POST['uid'];
    $email = $_POST['mail'];
    $password = $_POST['pwd'];
    $passwordRepeat  = $_POST['pwd-repeat'];
    $gender = $_POST['gender'];
    $headline = $_POST['headline'];
    $bio = $_POST['bio'];
    $f_name = $_POST['f-name'];
    $l_name = $_POST['l-name'];
    
    if (empty($userName) || empty($email) || empty($password) || empty($passwordRepeat))
    {
        header("Location: ../signup.php?error=emptyfields&uid=".$userName."&mail=".$email);
        exit();
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $userName))
    {
        header("Location: ../signup.php?error=invalidmailuid");
        exit();
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        header("Location: ../signup.php?error=invalidmail&uid=".$userName);
        exit();
    }
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $userName))
    {
        header("Location: ../signup.php?error=invaliduid&mail=".$email);
        exit();
    }
    else if ($password !== $passwordRepeat)
    {
        header("Location: ../signup.php?error=passwordcheck&uid=".$userName."&mail=".$email);
        exit();
    }
    else
    {
        // checking if a user already exists with the given username
        $sql = "select uidUsers from users where uidUsers=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("Location: ../signup.php?error=sqlerror");
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
                header("Location: ../signup.php?error=usertaken&mail=".$email);
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
                    header("Location: ../signup.php?error=sqlerror");
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
                    
                    header("Location: ../signup.php?signup=success");
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
    header("Location: ../signup.php");
    exit();
}