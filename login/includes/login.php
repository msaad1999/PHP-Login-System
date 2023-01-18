<?php

    session_start();

    require __DIR__ . '/../../assets/setup/settings.php'; 
    require __DIR__ . '/../../assets/includes/session_authorization.php';
    require __DIR__ . '/../../assets/includes/security_functions.php';

    check_if_its_logged_out(); // If there is any authorization redirects to home. Otherwise, does nothing (stay here).

    if (isset($_POST['dologin'])) {

        // foreach ($_POST as $key => $value) { $_POST[$key] = _cleaninjections(trim($value)); }

        if (!_cktoken()) { // ERRORS, loginstatus

            $_SESSION['ERRORS']['loginerror'] = 'A solicitação não pode ser validada.';
            header("Location: ../");
            exit();

        }

        /* SOME VALIDATION */

        $email = $_POST['email'];
        $pwd   = $_POST['pwd'];

        // e-Mail has to be validated again
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Invalid email

            $_SESSION['ERRORS']['emailerror'] = 'Dados inválidos';
            header("Location: ../");
            exit();
            
        } else { // Email domain error
            
            // and then the domain is checked as well
            if (!checkdnsrr(substr($email, strpos($email, '@') + 1), 'MX')) {

                $_SESSION['ERRORS']['emailerror'] = 'Dados inválidos';
                header("Location: ../");
                exit();

            }
        
        }

        if (strlen($pwd) < 8 || strlen($pwd) > 40) { // Length error
                
            $_SESSION['ERRORS']['passworderror'] = 'Dados inválidos';
            header("Location: ../");
            exit();

        }

        if (empty($email) || empty($pwd)) { // Empty fields

            $_SESSION['ERRORS']['emailerror'] = 'Dados inválidos';
            header("Location: ../");
            exit();
    
        } else {

            require __DIR__ . '/../../assets/includes/database_hub.php'; // If everything is fine at this point we can move on and try to login

            $C = connect(); // connection

            if ($C) {

                $hourAgo = time() - 60*60;
                $ip = getIpAddress();

                // How many times have the user tried to connect?
                $attempts = sqlSelect($C, 'SELECT 1 FROM user_login_attempts WHERE email=? AND ip=? AND attempt_time>?', 'ssi', $email, $ip, $hourAgo);

                // To disable MAX_LOGIN_ATTEMPTS_PER_HOUR 
                // go to settings.php and then change it to a number as high as 99
                if ($attempts && $attempts->num_rows >= MAX_LOGIN_ATTEMPTS_PER_HOUR) { // IS IT NECESSARY TO CHECK BOTH CONDITIONS?

                    // Something fishy
                    $_SESSION['ERRORS']['toomanyattempts'] = 'Muitas tentativas incorretas. Volte mais tarde';
                    header("Location: ../");
                    exit();

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

                                $_SESSION['ERRORS']['scripterror'] = 'Erro ao tentar gravar informações de login (SQL ERROR)';
                                header("Location: ../");
                                exit();

                            }

                        } else { // PASSWORD NOT OK

                            if (recordLoginAttempt($C, $email, $ip, time())) {
                                echo "Tentativa de login gravada";
                            } else {
                                echo "Não foi possível gravar a tentativa de login";
                            }
                            
                            $_SESSION['ERRORS']['passworderror'] = 'Dados inválidos';
                            header("Location: ../");
                            exit();

                        }

                    } else { // Email not found

                        $_SESSION['ERRORS']['emailerror'] = 'Dados inválidos';
                        header("Location: ../");
                        exit();

                    }

                }

            } else { // Conn error

                $_SESSION['ERRORS']['scripterror'] = 'Erro ao tentar logar (Connection ERROR)';
                header("Location: ../");
                exit();
    
            }

        }

    } else { // Form error

        $_SESSION['ERRORS']['formerror'] = 'Use a tela de login para entrar no sistema';
        header("Location: ../");
        exit();

    }

?>