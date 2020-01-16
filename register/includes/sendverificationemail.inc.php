<?php


require '../../assets/setup/env.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../assets/vendor/PHPMailer/src/Exception.php';
require '../../assets/vendor/PHPMailer/src/PHPMailer.php';
require '../../assets/vendor/PHPMailer/src/SMTP.php';

if (isset($_POST['signupsubmit'])) {

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $url = "localhost/loginsystem/verify/includes/verify.inc.php?selector=" . $selector . "&validator=" . bin2hex($token);
    $expires = 'DATE_ADD(NOW(), INTERVAL 1 HOUR)';


    $sql = "DELETE FROM auth_tokens WHERE user_email=? AND auth_type='account_verify';";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {

        $_SESSION['ERRORS']['sqlerror'] = 'SQL ERROR';
        header("Location: ../");
        exit();
    }
    else {

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
    }


    $sql = "INSERT INTO auth_tokens (user_email, auth_type, selector, token, expires_at) 
            VALUES (?, 'account_verify', ?, ?, " . $expires . ");";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {

        $_SESSION['ERRORS']['sqlerror'] = 'SQL ERROR';
        header("Location: ../");
        exit();
    }
    else {
        
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "sss", $email, $selector, $hashedToken);
        mysqli_stmt_execute($stmt);
    }


    mysqli_stmt_close($stmt);
    mysqli_close($conn);


    $to = $email;
    $subject = 'Verify Your Account';
    
    /*
    * -------------------------------------------------------------------------------
    *   Using email template
    * -------------------------------------------------------------------------------
    */

    $mail_variables = array();

    $mail_variables['APP_NAME'] = APP_NAME;
    $mail_variables['username'] = $username;
    $mail_variables['email'] = $email;
    $mail_variables['url'] = $url;

    $message = file_get_contents("./template_verificationemail.php");

    foreach($mail_variables as $key => $value) {
        
        $message = str_replace('{{ '.$key.' }}', $value, $message);
    }


    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = MAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;
        $mail->SMTPSecure = MAIL_ENCRYPTION;
        $mail->Port = MAIL_PORT;

        $mail->setFrom(MAIL_USERNAME, APP_NAME);
        $mail->addAddress($to, APP_NAME);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
    } 
    catch (Exception $e) {

        
    }

    /*
    * ------------------------------------------------------------
    *   Script Endpoint 
    * ------------------------------------------------------------
    */
}
else {

    header("Location: ../");
    exit();
}