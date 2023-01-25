<?php 

    /* SMTP Information */
    include __DIR__ . '/../setup/smtp.php';

    /* PHPMailer */
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    include __DIR__ . '/../vendor/PHPMailer/src/Exception.php';
    include __DIR__ . '/../vendor/PHPMailer/src/PHPMailer.php';
    include __DIR__ . '/../vendor/PHPMailer/src/SMTP.php';
    /* PHPMailer */

    function sendEmail($to, $who, $subject, $message) { // RETURNS TRUE OR FALSE

        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();
            $mail->Host       = MAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = MAIL_USERNAME;
            $mail->Password   = MAIL_PASSWORD;
            $mail->SMTPSecure = MAIL_ENCRYPTION;
            $mail->Port       = MAIL_PORT;

            $mail->setFrom(MAIL_USERNAME, APP_NAME);
            $mail->addAddress($to, $who); // Email, Name

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();
            
            return true; //echo 'Message has been sent';

        } catch (Exception $e) {

            return false; //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

        }

    }

?>