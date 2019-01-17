
<?php
    define('TITLE',"Contact Us | KLiK Prototype");
    include 'includes/header.php';
    require 'includes/email-server.php'
?>

<div id="contact">
    
    <hr>
    <h1>Contact Us!</h1>
    
    <?php
        
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception; 
        
        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';  
        require 'PHPMailer/src/SMTP.php';
        
        
        function has_header_injection($str){
            return preg_match('/[\r\n]/',$str);
        }
    
        if (isset($_POST['contact_submit'])){
            
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $msg = $_POST['message'];
            
            
            if (has_header_injection($name) || has_header_injection($email)){
                die();
            }
            
            if (! $name || ! $email || ! $msg){
                echo '<h4 class="error">All Fields Required.</h4>'
                . '<a href="contact.php" class="button block">go back and try again</a>';
                exit;
            }
            
            $subject = "$name sent you a message via your contact form";
            
            $message = "<strong>Name:</strong> $name<br>" # \r\n is a line break
                    . "<strong>Email:</strong> <i>$email</i><br><br>"
                    . "<strong>Message:</strong><br><br>$msg";
            
            if (isset($_POST['subscribe'])){
                
                $message .= "<br><br><br>"
                        . "<strong>IMPORTANT:</strong> Please add <i>$email</i> "
                        . "to your mailing list.<br>";
            }
            
            $mail = new PHPMailer(true);            
            
            try {
                $mail->isSMTP();                                      
                $mail->Host = 'smtp.gmail.com';                      
                $mail->SMTPAuth = true;                               
                $mail->Username = $SMTPuser;                                
                $mail->Password = $SMTPpwd;                           
                $mail->SMTPSecure = 'tls';                            
                $mail->Port = 587;                                    
                
                $mail->setFrom($SMTPuser, $SMTPtitle);
                $mail->addAddress($SMTPuser, $SMTPtitle);     

                $mail->isHTML(true);                                 
                $mail->Subject = $subject;
                $mail->Body    = $message;
 
                $mail->send();
            } 
            catch (Exception $e) {
                echo '<p class="error">Message could not be sent. Mailer Error: '. $mail->ErrorInfo
                        .'</p>';
            }
            
            echo "<h6> Thanks for contacting Franklin's!</h6>
                <h6>Please Allow 24 hours for a response</h6>";
        }
    ?>
    
    
    <form method="post" action="" id="contact-form">
        
        <label for="name">Name</label>
        <input type="text" id="name" name="name">
        
        <label for="email">Email</label>
        <input type="email" id="email" name="email">
        
        <label for="message">Message</label>
        <textarea id="message" name="message"></textarea>
        
        <input type="checkbox" id="subscribe" name="subscribe" value="subscribe">
        <label for="subscribe">Subscribe to newsletter</label>
        
        <input type="submit" class="button next" name="contact_submit" value="Send Message">
        
    </form>
    
    <hr>

</div>

<?php include 'includes/footer.php'; ?> 
