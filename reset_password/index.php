<?php

    define('TITLE', "Recuperar Senha");
    include __DIR__ . '/../assets/layouts/headie.php';
    check_if_its_logged_out();

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

<?php

    if (isset($_GET['selector']) && isset($_GET['token'])) {

        $uselector = $_GET['selector']; // Extract selector and token from URL
        $utoken = $_GET['token'];

?>

                    <h6 class="h4 mb-3 font-weight-normal text-center">Preencha os campos abaixo</h6>

                    <form class="form-auth" action="includes/reset.php" method="post">

                        <?php _placetoken(); ?>
                        <input type="hidden" name="selector" value="<?php echo $uselector; ?>">
                        <input type="hidden" name="validator" value="<?php echo $utoken; ?>">

                        <div class="text-center mb-3">
                            <sub class="text-danger">
                                <?php
                                    if (isset($_SESSION['ERRORS']['resetpassworderror']))
                                        echo $_SESSION['ERRORS']['resetpassworderror'];
                                ?>
                            </sub>
                        </div>

                        <!-- Password -->                       
                        <div class="form-floating mb-2">                    
                            <input type="password" id="pwd" name="pwd" class="form-control" maxlength="40" placeholder="Nova senha">
                            <label for="pwd">Nova senha</label>                
                        </div>                                

                        <!-- Confirm Password -->                       
                        <div class="form-floating mb-2">
                            <input type="password" id="cpwd" name="cpwd" class="form-control" maxlength="40" placeholder="Confirme a nova senha">
                            <label for="cpwd">Confirme a nova senha</label>
                        </div> 

                        <!-- SUBMIT -->
                        <div class="form-group">                        
                        </div>                        
                        <div class="form-group">                        
                            <button class="btn btn-primary w-100 btn-lg" data-mdb-ripple-color="#e225d2" type="submit" name='doreset'>Salvar</button>
                        </div>

                    </form>

<?php

    } else {

?>

                    <h6 class="h4 mb-3 font-weight-normal text-center">Por favor, digite o email que foi usado para criar a sua conta.</h6>
                    <h6 class="h4 mb-3 font-weight-normal text-center">Será enviado enviado um link para você resetar sua senha</h6>

                    <form action="includes/send_reset_email.php" method="POST" autocomplete="off">

                        <?php _placetoken(); ?>

                        <div class="text-center">
                            <sub class="text-danger fw-bold">
                                <?php
                                    if (isset($_SESSION['ERRORS']['sendresetemailerror']))
                                        echo $_SESSION['ERRORS']['sendresetemailerror'];
                                ?>
                            </sub>
                        </div>                        

                        <div class="form-floating mb-2">
                            <input type="text" id="email" name="email" class="form-control" maxlength="40" placeholder="Email">
                            <label for="email">Email</label>
                        </div>

                        <div class="form-group">                        
                            <button class="btn btn-primary w-100 btn-lg" data-mdb-ripple-color="#e225d2" type="submit" name='dosend'>Enviar email</button>
                        </div>

                    </form>

<?php

    }

?>

                </div>

            </div>

        </div>

        <?php

            include __DIR__ . '/../assets/layouts/footie.php';

        ?>

    <!-- /BODY -->
    
<!-- /HTML -->