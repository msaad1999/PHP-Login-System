<?php

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
                $fileDestination = '../uploads/users/' . $FileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);

            }
            else
            {
                header("Location: ../signup.php?error=imgsizeexceeded");
                exit(); 
            }
        }
        else
        {
            header("Location: ../signup.php?error=imguploaderror");
            exit();
        }
    }
    else
    {
        header("Location: ../signup.php?error=invalidimagetype");
        exit();
    }
}
