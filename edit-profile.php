<?php

    define(TITLE, "Edit Profile | Franklin's Fine Dining");
    include 'includes/header.php';
    
    if (!isset($_SESSION['userId']))
    {
        header("Location: index.php");
        exit();
    }
    
?>



<?php include 'includes/footer.php'; ?> 


