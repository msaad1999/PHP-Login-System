<?php

define('TITLE', "Welcome");
include '../assets/layouts/header.php';

?>



<main role="main">

    <section class="jumbotron text-center py-5">
        <div class="container">
            <h1 class="jumbotron-heading mb-4">PHP Login System</h1>
            <p class="text-muted">
                Embeddable and Secure Authentication System in PHP with User Profiles, Profile Editing, Login, Signup, Account Verification via 
                Email, Password Reset System and Remember Me Feature.
                
                <hr width="300" class="my-3">

                <sub>
                    This is an example intro page that can be accessed with or without logging into an account. This may be used as a default homepage
                    for the application with basic intro information.
                </sub>

                <hr width="300" class="my-3">

                <sub>
                    Hey if you like this small project, I would like it best if you decide to improve and contribute to it. We are probably
                    too far apart for me to demand a nice coffee but for now a star would suffice.
                </sub>
            </p>
            <p>
                <a href="https://github.com/msaad1999" class="btn btn-primary my-2" target="_blank">See Creator</a>
                <a href="https://github.com/msaad1999/PHP-Login-System" class="btn btn-secondary my-2" target="_blank">See Repository</a>
            </p>
        </div>
    </section>

    <div class="album py-5">
        <div class="container">

            <div class="text-center text-muted mb-5">
                <h2>Check Out My Similar Projects</h2>
                <hr width="300">
            </div>
        
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top" src='../assets/images/repo_gitklik.png' alt="Card image cap">
                        <div class="card-body">
                            <p class="card-text">Version Control application in Laravel using Git for core operationality.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a href="https://github.com/msaad1999/GitKLiK" class="btn btn-sm btn-outline-secondary" target="_blank">View</a>
                                    <a href="https://github.com/msaad1999/GitKLiK/archive/master.zip" class="btn btn-sm btn-outline-secondary" target="_blank">Download</a>
                                </div>
                                <small class="text-muted">[under development]</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top" src='../assets/images/repo_klik.png' alt="Card image cap">
                        <div class="card-body">
                            <p class="card-text">PHP social media website with additional blogs and forums functionality.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a href="https://github.com/msaad1999/KLiK-SocialMediaWebsite" class="btn btn-sm btn-outline-secondary" target="_blank">View</a>
                                    <a href="https://github.com/msaad1999/KLiK-SocialMediaWebsite/archive/master.zip" class="btn btn-sm btn-outline-secondary" target="_blank">Download</a>
                                </div>
                                <small class="text-muted">[development concluded]</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top" src='../assets/images/repo_loginsystem.png' alt="Card image cap">
                        <div class="card-body">
                            <p class="card-text">Embeddable and secure PHP authentication system.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a href="https://github.com/msaad1999/PHP-Login-System" class="btn btn-sm btn-outline-secondary" target="_blank">View</a>
                                    <a href="https://github.com/msaad1999/PHP-Login-System/archive/master.zip" class="btn btn-sm btn-outline-secondary" target="_blank">Download</a>
                                </div>
                                <small class="text-muted">[development concluded]</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</main>


<?php

include '../assets/layouts/footer.php'

?>