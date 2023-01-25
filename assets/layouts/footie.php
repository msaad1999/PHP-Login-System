
        <script src="../assets/vendor/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
        
        <?php if (isset($_SESSION['authorization'])) { ?> 
        
            <script src="../assets/js/isitinactive.js"></script>
        
        <?php } ?>

    </body>

</html>

<?php

    if (isset($_SESSION['ERRORS']))
        $_SESSION['ERRORS'] = NULL;

    if (isset($_SESSION['STATUS']))
        $_SESSION['STATUS'] = NULL;

?>