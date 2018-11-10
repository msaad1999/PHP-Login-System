<?php
    define('TITLE',"Signup | Franklin's Fine Dining");
    include 'includes/header.php';
?>

<div id="contact">
    
    <hr>
    <h1>Signup</h1>
    <?php
    
        $userName = '';
        $email = '';
    
        if(isset($_GET['error']))
        {
            if($_GET['error'] == 'emptyfields')
            {
                echo '<p class="closed">Fill In All The Fields</p>';
                $userName = $_GET['uid'];
                $email = $_GET['mail'];
            }
            else if ($_GET['error'] == 'invalidmailuid')
            {
                echo '<p class="closed">Please enter a valid email and user name</p>';
            }
            else if ($_GET['error'] == 'invalidmail')
            {
                echo '<p class="closed">Please enter a valid email</p>';
            }
            else if ($_GET['error'] == 'invaliduid')
            {
                echo '<p class="closed">Please enter a valid user name</p>';
            }
            else if ($_GET['error'] == 'passwordcheck')
            {
                echo '<p class="closed">Passwords donot match</p>';
            }
            else if ($_GET['error'] == 'usertaken')
            {
                echo '<p class="closed">This User name is already taken</p>';
            }
            else if ($_GET['error'] == 'sqlerror')
            {
                echo '<p class="closed">Website Error: Contact admin to have the issue fixed</p>';
            }
        }
        else if (isset($_GET['signup']) == 'success')
        {
            echo '<p class="open">Signup Successful</p>';
        }
    ?>
    <form action="includes/signup.inc.php" method='post' id="contact-form">

        <input type="text" id="name" name="uid" placeholder="Username" value=<?php echo $userName; ?>>
        <input type="email" id="email" name="mail" placeholder="email" value=<?php echo $email; ?>>
        <input type="password" id="pwd" name="pwd" placeholder="password">
        <input type="password" id="pwd-repeat" name="pwd-repeat" placeholder="repeat password">
        
        <h5>Gender</h5>
        <label class="container" for="gender-m">Male
          <input type="radio" checked="checked" name="gender" value="m" id="gender-m">
          <span class="checkmark"></span>
        </label>
        <label class="container" for="gender-f">Female
          <input type="radio" name="gender" value="f" id="gender-f">
          <span class="checkmark"></span>
        </label>

        <h5>Optional</h5>
        <input type="text" id="headline" name="headline" placeholder="Your Profile Headline">
        <textarea id="bio" name="bio" placeholder="What you want to tell people about yourself"></textarea>
        
        <input type="submit" class="button next" name="signup-submit" value="signup">
        
    </form>
    
    <hr>

</div>

<?php include 'includes/footer.php'; ?> 
