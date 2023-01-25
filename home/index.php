<?php

    define('TITLE', "Home - Dashboard");
    include __DIR__ . '/../assets/layouts/headie.php';
    check_if_its_verified(); // If it is not loggedin it will redirect to login

?>

<!-- HTML -->

    <!-- BODY -->  

        <div class="container mt-5">

            <div class="row justify-content-center mt-5">
                
                <div class="col-lg-4">

                    <div class="text-center">
                        <img class="mb-1" src="../assets/images/logo.png" alt="De Orlando para Você!">
                    </div>

                    <h6 class="h1 mb-3 font-weight-normal text-center"><?php echo APP_NAME; ?></h6>
                    <br>

                    <h6 class="h4 mb-3 font-weight-normal text-center">Home - Dashboard</h6>
                    <br>
                    
                    <h6 class="h4 mb-3 font-weight-normal text-center">Boas vindas, <?php echo $_SESSION['email']; ?></h6>
                    <br>

                    <p class="mt-3 text-muted text-center"><a href="../logout/">Logout</a></p>
                
                </div>
            
            </div>
    
        </div>
    
        <?php

            include __DIR__ . '/../assets/layouts/footie.php';

        ?>

    <!-- /BODY -->

<!-- /HTML -->