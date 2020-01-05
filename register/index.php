<?php

define('TITLE', "Signup | PHP Login System");
include '../assets/layouts/header.php';

?>


<div class="container">
    <div class="row">
        <div class="col-md-4">

        </div>
        <div class="col-lg-4">

            <form class="form-auth" action="includes/register.inc.php" method="post" enctype="multipart/form-data">

                <div class="picCard text-center">
                    <div class="avatar-upload">
                        <div class="avatar-preview text-center">
                            <div id="imagePreview" style="background-image: url( ../assets/uploads/default.png );"></div>
                        </div>
                        <div class="avatar-edit">
                            <input name='avatar' id="avatar" class="fas fa-pencil" type='file' />
                            <label for="avatar"></label>
                        </div>
                    </div>
                </div>

                <h6 class="h3 mt-3 mb-3 font-weight-normal text-muted text-center">Create an Account</h6>

                <div class="form-group">
                    <label for="username" class="sr-only">Username</label>
                    <input type="text" id="username" class="form-control" placeholder="Username" required autofocus>
                </div>

                <div class="form-group">
                    <label for="email" class="sr-only">Email address</label>
                    <input type="email" id="email" class="form-control" placeholder="Email address" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" id="password" class="form-control" placeholder="Password" required>
                </div>

                <div class="form-group mb-4">
                    <label for="confirmpassword" class="sr-only">Confirm Password</label>
                    <input type="password" id="confirmpassword" class="form-control" placeholder="Password" required>
                </div>

                <hr>
                <span class="h5 mb-3 font-weight-normal text-muted text-center">Optional</span>

                <div class="form-group mt-4">
                    <label for="headline" class="sr-only">Headline</label>
                    <input type="text" id="headline" class="form-control" placeholder="headline" required>
                </div>

                <div class="form-group">
                    <label for="bio" class="sr-only">Profile Details</label>
                    <textarea type="text" id="bio" class="form-control" required>Tell us about yourself...</textarea>
                </div>

                <div class="form-group">
                    <label>Gender</label>
                    <div class="custom-control custom-radio custom-control">
                        <input type="radio" id="male" name="gender" class="custom-control-input" value="m">
                        <label class="custom-control-label" for="male">Male</label>
                    </div>
                    <div class="custom-control custom-radio custom-control">
                        <input type="radio" id="female" name="gender" class="custom-control-input" value="f">
                        <label class="custom-control-label" for="female">Female</label>
                    </div>
                </div>

                <div class="col-auto my-1 mb-4">
                    <div class="custom-control custom-checkbox mr-sm-2">
                        <input type="checkbox" class="custom-control-input" id="rememberme">
                        <label class="custom-control-label" for="rememberme">Remember me</label>
                    </div>
                </div>

                <button class="btn btn-lg btn-primary btn-block" type="submit" value="register">Signup</button>

                <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>

            </form>

        </div>
        <div class="col-md-4">

        </div>
    </div>
</div>



<?php

include '../assets/layouts/footer.php'

?>

<script type="text/javascript">
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);

            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#avatar").change(function() {
        console.log("here");
        readURL(this);
    });
</script>