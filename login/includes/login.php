<?php

    session_start();

    require __DIR__ . '/../../assets/includes/utils.php';
    require __DIR__ . '/../../assets/setup/settings.php'; 
    require __DIR__ . '/../../assets/includes/session_authorization.php';
    require __DIR__ . '/../../assets/includes/security_functions.php';

    check_if_its_logged_out(); // If there is any authorization redirects to home. Otherwise, does nothing (stay here).

    if (isset($_POST['dologin'])) {

        if (!_cktoken()) { // ERRORS, loginstatus

            errorExiting('loginerror', 'A solicitação não pode ser validada');

        }

        /* SOME VALIDATION */

        $email = $_POST['email'];
        $pwd   = $_POST['pwd'];

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // Invalid email

            $domain = substr($email, strpos($email, '@') + 1);

            if (!checkdnsrr($domain, 'MX')) {

                errorExiting('emailerror', 'Email inválido');

            }
            
        } else {

            errorExiting('emailerror', 'Email inválido');

        }

        if (strlen($pwd) < 8 || strlen($pwd) > 40) { // Length error
                
            errorExiting('passworderror', 'Dados inválidos');

        } else {

            require __DIR__ . '/../../assets/includes/database_hub.php'; // If everything is fine at this point we can move on and try to login

            $C = connect(); // connection

            if ($C) {

                $hourAgo = time() - 60*60;
                $ip = getIpAddress();

                // How many times have the user tried to connect?
                $attempts = sqlSelect($C, 'SELECT 1 FROM user_login_reset_attempts WHERE email=? AND ip=? AND attempt_time>?', 'ssi', $email, $ip, $hourAgo);

                // To disable MAX_LOGIN_ATTEMPTS_PER_HOUR go to settings.php and change it to a number as high as 99
                if ($attempts && $attempts->num_rows >= MAX_LOGIN_ATTEMPTS_PER_HOUR) {

                    errorExiting('toomanyattempts', 'Muitas tentativas incorretas. Volte mais tarde');

                } else {

                    // Let's check now if the password is correct
                    $r = sqlSelect($C, 'SELECT id, pwd, verified_at FROM users WHERE email=?', 's', $email);

                    if ($r && $r->num_rows === 1) {

                        $usr = $r->fetch_assoc();

                        if (password_verify($pwd, $usr['pwd'])) { // PASSWORD OK

                            if (recordLastUserLogin($C, $email)) { // Last login information is saved and any unsuccessful login attempt is erased

                                if ($usr['verified_at'] != NULL) {

                                    $_SESSION['authorization'] = 'verified';                                    

                                } else {
            
                                    $_SESSION['authorization'] = 'loggedin';
                                    
                                }

                                $_POST = array();
                                
                                //session_regenerate_id(true); // Still trying to figure this out
                                $_SESSION['email'] = $email;

                                header("Location: ../../home/");
                                exit();

                            } else { // Could not store information about last login and unsuccessful login attempts could not be erased

                                errorExiting('scripterror', 'Erro ao tentar gravar informações de login (SQL ERROR)');

                            }

                        } else { // PASSWORD NOT OK

                            // This part needs improvements.
                            // If something goes wrong while recording the login attempt it means there's more to it
                            if (recordLoginAttempt($C, $email, $ip, time(), "L")) { // attempt_type L for Login
                                echo "Tentativa de login gravada";
                            } else {
                                echo "Não foi possível gravar a tentativa de login";
                            }
                            
                            errorExiting('passworderror', 'Dados inválidos');

                        }

                    } else { // Email not found

                        errorExiting('emailerror', 'Dados inválidos');

                    }

                }

            } else { // Conn error

                errorExiting('scripterror', 'Erro ao tentar conectar (CONN)');
    
            }

        }

    } else { // Form error

        errorExiting('formerror', 'Erro com o formulário');

    }

?>