<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="./home">
            Login System
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">


                <?php if (!isset($_SESSION['id'])) { ?>

                    <li class="nav-item">
                        <a class="nav-link" href="../login">Login</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../register">Signup</a>
                    </li>

                <?php } ?>





            </ul>
        </div>
    </div>
</nav>