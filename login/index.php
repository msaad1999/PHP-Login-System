<?php

define('TITLE', "Login | PHP Login System");
include '../assets/layouts/header.php';

if (isset($_SESSION['id'])) {

    header("Location: ../home");
    exit();
} 

?>


<div class="container">
    <div class="row">
        <div class="col-sm-4">

        </div>
        <div class="col-sm-4">
            <form class="form-auth" action="includes/login.inc.php" method="post">

                <div class="text-center">
                    <img class="mb-4" src="../assets/images/logo.png" alt="" width="92" height="92">
                </div>

                <h6 class="h3 mb-3 font-weight-normal text-muted  text-center">Login to your Account</h6>

                <div class="form-group">
                    <label for="inputEmail" class="sr-only">Username</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
                </div>

                <div class="form-group">
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <div class="col-auto my-1 mb-4">
                    <div class="custom-control custom-checkbox mr-sm-2">
                        <input type="checkbox" class="custom-control-input" id="rememberme" name="rememberme">
                        <label class="custom-control-label" for="rememberme">Remember me</label>
                    </div>
                </div>

                <button class="btn btn-lg btn-primary btn-block" type="submit" value="loginsubmit" name="loginsubmit">Login</button>

                <p class="mt-5 mb-3 text-muted text-center">&copy; 2017-2018</p>
                
            </form>
        </div>
        <div class="col-sm-4">

        </div>
    </div>
</div>


<?php

include '../assets/layouts/footer.php'

?>