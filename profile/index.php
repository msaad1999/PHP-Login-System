<?php

define('TITLE', "Home | PHP Login System");
include '../assets/layouts/header.php';

// if (!isset($_SESSION['userId'])) {

//     header("Location: ../login");
//     exit();
// } 

?>




<div class="row py-5 px-4 ">
    <div class="col-xl-12 col-md-12 col-sm-12 mx-auto ">

        <!-- Profile widget -->
        <div class="bg-white shadow rounded overflow-hidden">
            <div class="px-4 pt-5 pb-5 bg-dark profile-cover">
                <div class="media align-items-end profile-header">
                    <div class="profile mr-3">
                        <img src="https://d19m59y37dris4.cloudfront.net/university/1-1-1/img/teacher-4.jpg" alt="..." width="130" class="rounded mb-2 img-thumbnail">
                        <a href="#" class="btn btn-dark btn-sm btn-block">Edit profile</a>
                    </div>
                    <div class="media-body mb-5 text-white">
                        <h4 class="mt-0 mb-0">Manuella Tarly</h4>
                        <p class="small mb-4">
                            <i class="fa fa-map-marker mr-2"></i>San Farcisco <br>
                            <i class="fa fa-map-marker mr-2"></i>San aaaaaaa
                        </p>
                    </div>
                </div>
            </div>


        </div><!-- End profile widget -->

    </div>
</div>



<?php

include '../assets/layouts/footer.php'

?>