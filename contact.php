<?php
    define('TITLE',"Menu | Franklin's Fine Dining");
    include 'includes/header.php';
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
        
        
        // check for header injection
        function has_header_injection($str){
            return preg_match('/[\r\n]/',$str);
        }
    
        if (isset($_POST['contact_submit'])){
            
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $msg = $_POST['message'];
            
            
            // check if name / mail (fields) have header injection
            if (has_header_injection($name) || has_header_injection($email)){
                die(); // kill the script immediately
            }
            
            if (! $name || ! $email || ! $msg){
                echo '<h4 class="error">All Fields Required.</h4>'
                . '<a href="contact.php" class="button block">go back and try again</a>';
                exit;
            }
            
            
            
            // add the recipient email to a variable
            $to = "saad01.1999@gmail.com";
            
            // create a subject
            $subject = "$name sent you a message via your contact form";
            
            // create message
            $message = "<strong>Name:</strong> $name<br>" # \r\n is a line break
                    . "<strong>Email:</strong> <i>$email</i><br><br>"
                    . "<strong>Message:</strong><br><br>$msg";
            
            // check if subscribe checkbox was checked
            if (isset($_POST['subscribe'])){
                
                // add new line to message variable
                $message .= "<br><br><br>"
                        . "<strong>IMPORTANT:</strong> Please add <i>$email</i> "
                        . "to your mailing list.<br>";
            }
            
            // send the email (used PHPMailer since mail() does not send email on localhost in WIINDOWS
            $mail = new PHPMailer(true);            
            
            try {
                //Server settings
                //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
                
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';                      // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = $to;                                // SMTP username
                $mail->Password = 'test123';                           // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                    // TCP port to connect to
                
                //Recipients
                $mail->setFrom($to, "Franklin's Fine Dining");
                $mail->addAddress($to, "Franklin's Fine Dining");     // Add a recipient

                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = $message;
 
                $mail->send();
            } 
            catch (Exception $e) {
                echo '<h4 class="error">Message could not be sent. Mailer Error: '. $mail->ErrorInfo
                        .'</h4>';
            }
        
    ?>
    
    <!-- Show success message after email is sent -->
    <h5> Thanks for contacting Franklin's!</h5>
    <p>Please Allow 24 hours for a response</p>
    <p><a href='index.php' class='button block'>&laquo; Go To Home Page</a></p>
    
    
    <?php } else{ ?>
     
  
    
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
    
    <?php } ?>   
    
    <hr>

</div>

<?php include 'includes/footer.php'; ?> 
