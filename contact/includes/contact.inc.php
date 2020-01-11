<?php

session_start();

require '../../assets/setup/env.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../assets/vendor/PHPMailer/src/Exception.php';
require '../../assets/vendor/PHPMailer/src/PHPMailer.php';
require '../../assets/vendor/PHPMailer/src/SMTP.php';

require '../../assets/includes/functions.php';

if (isset($_POST['contact-submit'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $msg = $_POST['message'];


    if (has_header_injection($name) || has_header_injection($email)) {
        die();
    }

    if (!$name || !$email || !$msg) {
        echo '<h4 class="error">All Fields Required.</h4>'
            . '<a href="contact.php" class="button block">go back and try again</a>';
        exit;
    }

    $subject = "$name sent you a message via your contact form";

    $message = "<strong>Name:</strong> $name<br>" # \r\n is a line break
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