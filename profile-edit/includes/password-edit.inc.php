<?php

if (isset($_POST['update-profile'])) {

    if( !empty($oldPassword) && !empty($newpassword) && !empty($passwordrepeat)){

        $sql = "SELECT password FROM users WHERE id=?;";
        $stmt = mysqli_stmt_init($conn);
        
        if (!mysqli_stmt_prepare($stmt, $sql)){

            header("Location: ../?error=sqlerror");
            exit();
        }
        else{

            mysqli_stmt_bind_param($stmt, "s", $_SESSION['id']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if($row = mysqli_fetch_assoc($result)){

                $pwdCheck = password_verify($oldPassword, $row['password']);
                if ($pwdCheck == false)
                {
                    header("Location: ../?error=wrongpwd");
                    exit();
                }
                if ($oldPassword == $newpassword)
                {
                    header("Location: ../?error=samepwd");
                    exit();
                }
                if ($newpassword !== $passwordrepeat)
                {
                    header("Location: ../?error=wrongconfirmpassword");
                    exit();
                }

                $pwdChange = true;
            }
        }
    }
    else{

        header("Location: ../?error=emptypwdfields");
        exit();
    }  
} 
else {

    header("Location: ../");
    exit();
}
