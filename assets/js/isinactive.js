$(document).ready(function() {
    setInterval(function() {
        $.ajax({
            type: 'GET',
            async: false,
            url: '../assets/includes/isinactive.php',
            success: function(response) {
                if (response == 'logged_out') {
                    location.href = "../login/";
                }
            }
        });
    }, 5000);
});