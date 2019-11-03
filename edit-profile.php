<?php

    define('TITLE', "Edit Profile | Franklin's Fine Dining");
    include 'includes/header.php';
    
    if (!isset($_SESSION['userId']))
    {
        header("Location: index.php");
        exit();
    }
    
?>
<div style="text-align: center">
    <img id="userDp" src=<?php echo "./uploads/".$_SESSION['userImg']; ?> >
 
    <h1><?php echo strtoupper($_SESSION['userUid']); ?></h1>
</div>


<?php
    
        $userName = '';
        $email = '';
    
        if(isset($_GET['error']))
        {
            if($_GET['error'] == 'emptyemail')
            {
                echo '<p class="closed">*Profile email cannot be empty</p>';
                $email = $_GET['mail'];
            }
            else if ($_GET['error'] == 'invalidmail')
            {
                echo '<p class="closed">*Please enter a valid email</p>';
            }
            else if ($_GET['error'] == 'emptyoldpwd')
            {
                echo '<p class="closed">*You must enter the current password to change it</p>';
            }
            else if ($_GET['error'] == 'emptynewpwd')
            {
                echo '<p class="closed">*Please enter the new password</p>';
            }
            else if ($_GET['error'] == 'emptyreppwd')
            {
                echo '<p class="closed">*Please confirm new password</p>';
            }
            else if ($_GET['error'] == 'wrongpwd')
            {
                echo '<p class="closed">*Current password is wrong</p>';
            }
            else if ($_GET['error'] == 'samepwd')
            {
                echo '<p class="closed">*New password cannot be same as old password</p>';
            }
            else if ($_GET['error'] == 'passwordcheck')
            {
                echo '<p class="closed">*Confirmation password is not the same as the new password</p>';
            }
        }
        else if (isset($_GET['edit']) == 'success')
        {
            echo '<p class="open">*Profile Updated Successfully</p>';
        }
?>


<form action="includes/profileUpdate.inc.php" method='post' id="contact-form" enctype="multipart/form-data">

        <h5>Personal Information</h5>
        
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="email" 
               value=<?php echo $_SESSION['emailUsers']; ?>><br>
        
        
        <label>Full Name</label>
        <input type="text" id="f-name" name="f-name" placeholder="First Name" 
               value=<?php echo $_SESSION['f_name']; ?>>
        <input type="text" id="l-name" name="l-name" placeholder="Last Name" 
               value=<?php echo $_SESSION['l_name']; ?>>
        
        <label class="container" for="gender-m">Male
          <input type="radio" name="gender" value="m" id="gender-m"
                 <?php if ($_SESSION['gender'] == 'm'){ ?> 
                 checked="checked"
                 <?php } ?>>
          <span class="checkmark"></span>
        </label>
        <label class="container" for="gender-f">Female
          <input type="radio" name="gender" value="f" id="gender-f"
                 <?php if ($_SESSION['gender'] == 'f'){ ?> 
                 checked="checked"
                 <?php } ?>>
          <span class="checkmark"></span>
        </label>
       
        <label for="headline">Profile Headline</label>
        <input type="text" id="headline" name="headline" placeholder="Your Profile Headline"
               value='<?php echo $_SESSION['headline']; ?>'><br>
        
        <label for="bio">Profile Bio</label>
        <textarea id="bio" name="bio" maxlength="5000"
            placeholder="What you want to tell people about yourself" 
            ><?php echo $_SESSION['bio']; ?></textarea>
        
        <h5>Change Password</h5>
        <input type="password" id="old-pwd" name="old-pwd" placeholder="current password"><br>
        <input type="password" id="pwd" name="pwd" placeholder="new password">
        <input type="password" id="pwd-repeat" name="pwd-repeat" placeholder="repeat new password">
        
        <h5>Profile Picture</h5>
        <div class="upload-btn-wrapper">
            <button class="btn">Upload a file</button>
            <input type="file" name='dp' value=<?php echo $_SESSION['userImg']; ?>>
        </div>
        
        <input type="submit" class="button next" name="update-profile" value="Update Profile">
        
    </form>

<hr>

<?php include 'includes/footer.php'; ?> 


    