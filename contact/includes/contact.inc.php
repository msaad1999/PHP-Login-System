<?php

session_start();

require '../../assets/setup/env.php';
require '../../assets/includes/security_functions.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../assets/vendor/PHPMailer/src/Exception.php';
require '../../assets/vendor/PHPMailer/src/PHPMailer.php';
require '../../assets/vendor/PHPMailer/src/SMTP.php';

if (isset($_POST['contact-submit'])) {

    /*
    * -------------------------------------------------------------------------------
    *   Securing against Header Injection
    * -------------------------------------------------------------------------------
    */

    foreach($_POST as $key => $value){

        $_POST[$key] = _cleaninjections(trim($value));
    }

    
    if (isset($_SESSION['auth'])){

        $name = $_SESSION['username'];
        $email = $_SESSION['email'];
    }
    else {
        
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

            $_SESSION['ERRORS']['emailerror'] = 'invalid email';
            header("Location: ../");
            exit();
        }

        $name = $_POST['name'];
        $email = $_POST['email'];
    }

    $msg = $_POST['message'];


    if (!isset($_SESSION['auth']) && (!$name || !$msg)) {

        $_SESSION['ERRORS']['mailstatus'] = 'Fields cannot be empty';
        header("Location: ../");
        exit();
    }

    $subject = "$name sent you a message via your contact form";

    $message = "<strong>Name:</strong> $name<br>" 
        . "<strong>Email:</strong> <i>$email</i><br><br>"
        . "<strong>Message:</strong><br><br>$msg";

    if (isset($_POST['subscribe'])) {

        $message .= "<br><br><br>"
            . "<strong>IMPORTANT:</strong> Please add <i>$email</i> "
            . "to your mailing list.<br>";
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
        $mail->addAddress(MAIL_USERNAME, APP_NAME);

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

    $_SESSION['STATUS']['mailstatus'] = 'Thanks for contacting! Please Allow 24 hrs for a response';
    header("Location: ../");
    exit();
}
else {

    header("Location: ../");
    exit();
}