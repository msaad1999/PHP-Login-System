<?php

session_start();

require '../../assets/includes/auth_functions.php';
check_logged_out();

require '../../assets/setup/env.php';
require '../../assets/setup/db.inc.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../assets/vendor/PHPMailer/src/Exception.php';
require '../../assets/vendor/PHPMailer/src/PHPMailer.php';
require '../../assets/vendor/PHPMailer/src/SMTP.php';

require '../../assets/includes/functions.php';

if (isset($_POST['resentsend'])) {

    /*
    * -------------------------------------------------------------------------------
    *   Securing against Header Injection
    * -------------------------------------------------------------------------------
    */

    foreach($_POST as $key => $value){

        $_POST[$key] = _cleaninjections(trim($value));
    }

    /*
    * -------------------------------------------------------------------------------
    *   Verifying CSRF token
    * -------------------------------------------------------------------------------
    */

    if (!verify_csrf_token()){

        $_SESSION['STATUS']['resentsend'] = 'Request could not be validated';
        header("Location: ../");
        exit();
    }


    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $url = "localhost/loginsystem/reset-password/?selector=" . $selector . "&validator=" . bin2hex($token);
    $expires = 'DATE_ADD(NOW(), INTERVAL 1 HOUR)';

    $email = $_POST['email'];

    $sql = "SELECT id FROM users WHERE email=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){

        $_SESSION['ERRORS']['sqlerror'] = 'SQL ERROR';
        header("Location: ../");
        exit();
    }
    else {

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 0){

            $_SESSION['ERRORS']['emailerror'] = 'given email does not exist';
            header("Location: ../");
            exit();
        }
    }


    $sql = "DELETE FROM auth_tokens WHERE user_email=? AND auth_type='password_reset';";
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
            VALUES (?, 'password_reset', ?, ?, " . $expires . ");";
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
    $subject = 'Reset Your Password';
    $message = '<p>We received a password reset request. The link to your password is below.
            if you did not make this request, you can ignore this email.</p></br>
            <p>Here is your password reset link: </br>
            <a href=""' . $url . '">' .  $url . '</a></p>';

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

        // for public use
        $_SESSION['STATUS']['mailstatus'] = 'message could not be sent, try again later';

        // for development use
        // $_SESSION['STATUS']['mailstatus'] = 'message could not be sent. ERROR: ' . $mail->ErrorInfo;

        header("Location: ../");
        exit();
    }

    $_SESSION['STATUS']['resentsend'] = 'verification email sent';
    header("Location: ../");
    exit();
}
else {

    header("Location: ../");
    exit();
}