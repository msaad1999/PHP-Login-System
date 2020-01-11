<?php

define('TITLE', "Verify Email");
include '../assets/layouts/header.php';

if (!isset($_SESSION['id'])) {

    header("Location: ../login");
    exit();
} 

?>


<main role="main" class="container">

    <div class="row">
        <div class="col-sm-3">

            <?php include('../assets/layouts/profile-card.php'); ?>

        </div>
        <div class="shadow-lg box-shadow col-sm-7 px-5 m-5 bg-light rounded align-self-center verify-message">

            <h5 class="text-center mb-5 text-primary">Verify Your Email Address</h5>

            <p>
                Before proceeding, please check your email for a verification link. If you did not receive the email, 
                <a href="#">click here to send another</a>.
            </p>

        </div>
    </div>
</main>


<?php

include '../assets/layouts/footer.php'

?>