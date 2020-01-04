<?php

define('TITLE', "Home | PHP Login System");
include '../assets/layouts/header.php';

if (!isset($_SESSION['userId'])) {

    header("Location: ../login");
    exit();
} 

?>





<?php

include '../assets/layouts/footer.php'

?>