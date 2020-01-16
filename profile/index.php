<?php

define('TITLE', "Profile");
include '../assets/layouts/header.php';
check_verified();

?>

<div class="row py-5 px-4 ">
    <div class="col-xl-12 col-md-12 col-sm-12 mx-auto ">

        <!-- Profile widget -->
        <div class="bg-white shadow rounded overflow-hidden">
            <div class="px-4 pt-5 pb-5 bg-dark profile-cover">
                <div class="media align-items-end profile-header">
                    <div class="profile mr-3">
                        <img src="../assets/uploads/users/<?php echo $_SESSION['profile_image']; ?>" alt="..." width="130" class="rounded mb-2 img-thumbnail">
                        <a href="../profile-edit" class="btn btn-dark btn-sm btn-block">Edit profile</a>
                    </div>
                    <div class="media-body mb-5 text-white">
                        <h4 class="mt-0 mb-0"><?php echo $_SESSION['username']; ?></h4>
                        <p class="small">

                            <?php if ($_SESSION['gender'] == 'm'){ ?>

                            <i class="fa fa-male"></i>
                            

                            <?php } elseif ($_SESSION['gender'] == 'f'){ ?>

                            <i class="fa fa-female"></i>

                            <?php } ?>

                            <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?>
                        </p>

                        <p class="mb-4">
                            <?php echo $_SESSION['headline']; ?>
                        </p>
                    </div>
                </div>
            </div>


        </div>

    </div>
</div>

<div class="row bio">

    <div class="col-xl-6 col-md-9 col-sm-12 mx-auto">
    
    <?php echo $_SESSION['bio']; ?> 

    </div>

</div>



<?php

include '../assets/layouts/footer.php'

?>