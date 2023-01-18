<?php

    define('TITLE', "Verificar Email");
    include '../assets/layouts/headie.php';
    check_if_its_logged_in_but_its_not_verified(); // If $_SESSION['authorization'] is Verified redirect to HOME, 
                                                   // if $_SESSION['authorization'] is just loggedIn do nothing, stay here (user must verify email in some way) and
                                                   // if $_SESSION['authorization'] is not set redirect to LOGIN.

?>

<!-- HTML -->

    <!-- BODY -->   
    
        <div class="container mt-5">

            <div class="row justify-content-center mt-5">
    
                <div class="col-lg-4">
        
                    <div class="text-center">
                        <img class="mb-1" src="../assets/images/Shop2pacK_logo1.png" alt="De Orlando para Você!">
                    </div>

                    <h6 class="h1 mb-3 font-weight-normal text-center">Shop2pacK</h6>
                    <br>

                    <h6 class="h4 mb-3 font-weight-normal text-center">Verifique seu Email</h6>

                    <form action="includes/send_verif_email.php" method="POST">

                        <!--  Placing the token -->
                        <?php _placetoken(); ?>

                        <p>
                            O seu email ainda não foi validado no sistema.<br>
                            Se você não recebeu o email para verificação 
                            <button type="submit" name="doverify">clique aqui para enviar um novo email</button>.
                        </p>
                        <br>

                        <p class="mt-3 text-muted text-center"><a href="../logout/">Logout</a></p>

                    </form>

                </div>

            </div>

        </div>

        <?php

            include __DIR__ . '/../assets/layouts/footie.php';

        ?>

    <!-- /BODY -->

<!-- /HTML -->