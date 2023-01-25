<?php

    define('TITLE', "Cadastre-se");
    include __DIR__ . '/../assets/layouts/headie_nocache.php';
    check_if_its_logged_out(); // IF THERE IS ANY AUTHORIZATION REDIRECTS TO HOME, SKIPS LOGIN

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

                    <h6 class="h4 mb-3 font-weight-normal text-center">Cadastre-se</h6>

                    <form action="includes/signup.php" method="POST" autocomplete="off">

                        <!--  Placing the token -->
                        <?php _placetoken(); ?>

                        <!-- Checking the token after the form is submitted -->
                        <div class="text-center">                    
                            <small class="text-danger fw-bold">                        
                                <?php                                
                                    if (isset($_SESSION['ERRORS']['signuperror']))
                                        echo $_SESSION['ERRORS']['signuperror'];
                                ?>
                            </small>                        
                        </div>

                        <!-- Full Name -->
                        <div class="form-floating mb-2">                        
                            <input type="text" id="fullname" name="fullname" class="form-control" maxlength="40" placeholder="Nome Completo">
                            <label for="fullname">Nome Completo</label>
                            <sub class="text-danger fw-bold">                    
                                <?php                        
                                    if (isset($_SESSION['ERRORS']['fullnameerror']))
                                        echo $_SESSION['ERRORS']['fullnameerror'];
                                ?>
                            </sub>                       
                        </div>

                        <!-- Phone -->
                        <div class="form-floating mb-2">                    
                            <input type="text" id="phone" name="phone" class="form-control" maxlength="15" placeholder="Telefone" onkeyup="brCelPhoneMask(event)">
                            <label for="phone">Telefone (00) 90000-0000 ou (00) 0000-0000</label>
                            <sub class="text-danger fw-bold">                        
                                <?php                                    
                                    if (isset($_SESSION['ERRORS']['phoneerror']))
                                        echo $_SESSION['ERRORS']['phoneerror'];
                                ?>
                            </sub>                
                        </div>

                        <!-- Phone input mask -->
                        <script>
                            function brCelPhoneMask(event) {
                                var val = document.getElementById("phone").attributes[0].ownerElement['value'];
                                var ret = val.replace(/\D/g, "");
                                ret = ret.replace(/^0/, "");
                                if (ret.length > 10) {
                                    ret = ret.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
                                } else if (ret.length > 5) {
                                    if (ret.length == 6 && event.code == "Backspace") { 
                                        return;
                                    }
                                    ret = ret.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
                                } else if (ret.length > 2) {
                                    ret = ret.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
                                } else {
                                    if (ret.length != 0) {
                                        ret = ret.replace(/^(\d*)/, "($1");
                                    }
                                }
                                document.getElementById("phone").attributes[0].ownerElement['value'] = ret;
                            }
                        </script>

                        <!-- Instagram -->
                        <div class="form-floating mb-2">                    
                            <input type="text" id="instagram" name="instagram" class="form-control" maxlength="30" placeholder="Instagram">
                            <label for="instagram">Instagram sem o @</label>                   
                            <sub class="text-danger fw-bold">                        
                                <?php                                    
                                    if (isset($_SESSION['ERRORS']['instagramerror']))
                                        echo $_SESSION['ERRORS']['instagramerror'];
                                ?>
                            </sub>                
                        </div>                        

                        <!-- E-Mail -->                   
                        <div class="form-floating mb-2">                    
                            <input type="email" id="email" name="email" class="form-control" maxlength="40" placeholder="Email">
                            <label for="email">Email</label>                   
                            <sub class="text-danger fw-bold">                        
                                <?php                                    
                                    if (isset($_SESSION['ERRORS']['emailerror']))
                                        echo $_SESSION['ERRORS']['emailerror'];
                                ?>
                            </sub>                
                        </div>

                        <!-- Password -->                       
                        <div class="form-floating mb-2">                    
                            <input type="password" id="pwd" name="pwd" class="form-control" maxlength="40" placeholder="Senha">
                            <label for="pwd">Senha</label>                
                        </div>                                

                        <!-- Confirm Password -->                       
                        <div class="form-floating mb-2">
                            <input type="password" id="cpwd" name="cpwd" class="form-control" maxlength="40" placeholder="Confirme a senha">
                            <label for="cpwd">Confirme a senha</label>                
                            <sub class="text-danger fw-bold">                        
                                <?php                                    
                                    if (isset($_SESSION['ERRORS']['passworderror']))
                                        echo $_SESSION['ERRORS']['passworderror'];
                                ?>
                            </sub>                        
                        </div>                        

                        <!-- SUBMIT -->
                        <div class="form-group">                        
                        </div>                        
                        <div class="form-group">                        
                            <button class="btn btn-primary w-100 btn-lg" data-mdb-ripple-color="#e225d2" type="submit" name='dosignup'>Criar conta</button>
                        </div>

                        <p class="mt-3 text-muted text-center"><a href="../login/">Se você já tem uma conta clique aqui para logar</a></p>

                    </form>

                </div>

            </div>

        </div>

        <?php

            include __DIR__ . '/../assets/layouts/footie.php';

        ?>

    <!-- /BODY -->

<!-- /HTML -->