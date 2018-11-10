<?php
    define('TITLE',"Menu | Franklin's Fine Dining");
    include 'includes/header.php';
?>

<div id="contact">
    
    <h1>Signup</h1>
    <?php
        if(isset($_GET['error']))
        {
            if($_GET['error'] == 'emptyfields')
            {
                echo '<p class="closed">Fill In All The Fields</p>';
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

        <input type="text" id="name" name="uid" placeholder="Username">
        <input type="email" id="email" name="mail" placeholder="email">
        <input type="password" id="name" name="pwd" placeholder="password">
        <input type="password" id="name" name="pwd-repeat" placeholder="repeat password">

        <input type="submit" class="button next" name="signup-submit" value="Signup">

    </form>

</div>

<?php include 'includes/footer.php'; ?> 
