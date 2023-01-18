<?php

    define('TITLE', "Login");
    include __DIR__ . '/../assets/layouts/headie.php';
    check_if_its_logged_out(); // IF THERE IS ANY AUTHORIZATION REDIRECTS TO HOME, SKIPS LOGIN

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

                    <h6 class="h4 mb-3 font-weight-normal text-center">Login</h6>

                    <form action="includes/login.php" method="POST" autocomplete="off">

                        <!--  Placing the token -->
                        <?php _placetoken(); ?>

                        <!-- Checking the token -->
                        <div class="text-center">
                            <small class="text-success fw-bold">
                                <?php

                                    if (isset($_SESSION['STATUS']['loginstatus'])) // resetpwd.php???
                                        echo $_SESSION['STATUS']['loginstatus'];
                                        
                                    if (isset($_SESSION['STATUS']['verifystatus'])) // After verifying URL sent by email
                                        echo $_SESSION['STATUS']['verifystatus'];

                                    if (isset($_SESSION['STATUS']['resetstatus'])) // After resetting password
                                    echo $_SESSION['STATUS']['resetstatus'];
                                
                                ?>
                            </small>
                            <sub class="text-danger fw-bold">
                                <?php

                                    if (isset($_SESSION['ERRORS']['loginerror'])) // token error
                                        echo $_SESSION['ERRORS']['loginerror'];

                                    if (isset($_SESSION['ERRORS']['toomanyattempts']))
                                        echo $_SESSION['ERRORS']['toomanyattempts'];
                                    
                                    if (isset($_SESSION['ERRORS']['formerror']))
                                        echo $_SESSION['ERRORS']['formerror'];

                                    if (isset($_SESSION['ERRORS']['scripterror']))
                                        echo $_SESSION['ERRORS']['scripterror'];

                                    if (isset($_SESSION['ERRORS']['verifyerror'])) // something wrong with the token URL
                                        echo $_SESSION['ERRORS']['verifyerror'];

                                    if (isset($_SESSION['ERRORS']['emailerror']))
                                        echo $_SESSION['ERRORS']['emailerror'];

                                    if (isset($_SESSION['ERRORS']['passworderror']))
                                        echo $_SESSION['ERRORS']['passworderror'];
                                    
                                ?>
                            </sub>
                        </div>

                        <!-- Email -->
                        <div class="form-floating mb-2">
                            <input type="text" id="email" name="email" class="form-control" maxlength="40" placeholder="Email">
                            <label for="email">Email</label>
                        </div>

                        <!-- Password -->
                        <div class="form-floating mb-2">
                            <input type="password" id="pwd" name="pwd" class="form-control" maxlength="40" placeholder="Senha">
                            <label for="pwd">Senha</label>
                        </div>

                        <!-- SUBMIT -->
                        <div class="form-group">                        
                        </div>
                        <div class="form-group">                        
                            <button class="btn btn-primary w-100 btn-lg" data-mdb-ripple-color="#e225d2" type="submit" name='dologin'>Entrar</button>
                        </div>

                        <p class="mt-3 text-muted text-center"><a href="../reset_password/">Se você esqueceu a senha clique aqui</a></p>
                        <p class="mt-3 text-muted text-center"><a href="../signup/">Se você ainda não fez o cadastro clique aqui</a></p>
                
                    </form>

                </div>

            </div>

        </div>

        <?php

        include __DIR__ . '/../assets/layouts/footie.php';

        ?>

    <!-- /BODY -->

<!-- /HTML -->