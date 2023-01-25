<?php

    session_start();
    session_unset();
    session_destroy();

?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="description" content="daLogin">
        <meta name="author" content="daLogin">
        <meta name="keywords" content="" />

        <title>daLogin | Email enviado</title>
        <link rel="icon" type="image/png" href="../assets/images/favicon.png">

        <link rel="stylesheet" href="../assets/vendor/bootstrap-5.0.2-dist/css/bootstrap.min.css">
        
        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

        <!--script src="../assets/vendor/js/jquery-3.4.1.min.js"></script-->
        

    
        <!-- Custom styles -->
        <link rel="stylesheet" href="../assets/css/app.css">
        <link rel="stylesheet" href="custom.css">

    </head>

    <body>  
    
        <div class="container mt-5">

            <div class="row justify-content-center mt-5">
                
                <div class="col-lg-4">
                    
                    <div class="text-center">
                        <img class="mb-1" src="../assets/images/logo.png" alt="De Orlando para Você!">
                    </div>

                    <div class="text-center">
                        <h6 class="h1 mb-3 font-weight-normal text-center">daLogin</h6>
                        <br>
                    </div>

                    <div class="text-center">
                        <h6 class="h4 mb-3 font-weight-normal text-center"></h6>
                        <br>
                    </div>

                    <div class="text-center">
                        <h7 class="h4 mb-3 font-weight-normal text-center">Verifique o email que foi enviado para ter acesso ao sistema</h7>
                        <br>
                    </div>

                    <div class="text-center">
                        <p class="mt-3 text-muted text-center"><a href="../login/">Login</a></p>
                    </div>

                </div>

            </div>

        </div>

        <!--script src="../assets/vendor/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script-->

        <?php

            //include __DIR__ . '/../assets/layouts/footie.php';

        ?>

    </body>
    <!-- /BODY -->
</html>
<!-- /HTML -->