<?php

    if(!session_id()) session_start();

    require_once 'layouts/header.php';
    require_once 'layouts/footer.php';

    require_once 'class/Database.php';
    require_once 'class/User.php';

    require_once 'lib/Validation.php';
    require_once 'lib/Flasher.php';
    require_once 'lib/Pagination.php';

?>