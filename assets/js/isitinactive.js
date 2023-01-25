
function checkIfItsExpired() {

    $.ajax({

        url: "../assets/includes/isitinactive.php",
        method: "POST",
        success: function(response) {

            /* the response is the output of the php file above */
            if (response == 'itisinactive_redirecttologin') {

                window.location.href = "../logout/";

            }

        }

    });

}

/**
 * Check if session is expired every 10 seconds 
 */
setInterval(function() { checkIfItsExpired(); } , 10000);
