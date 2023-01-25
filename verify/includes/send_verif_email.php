<?php

    session_start();

    require __DIR__ . '/../../assets/includes/utils.php';
    require __DIR__ . '/../../assets/setup/settings.php'; 
    require __DIR__ . '/../../assets/includes/session_authorization.php';
    require __DIR__ . '/../../assets/includes/security_functions.php';

    check_if_its_logged_in_but_not_verified(); // If $_SESSION['authorization'] is Verified redirect to HOME, 
                                               // if it's just loggedIn do nothing (user must verify email in some way)
                                               // and if it's not set redirect to LOGIN.

    if (isset($_POST['doverify'])) {

        if (!_cktoken()) { // ERRORS, verifystatus

            errorExiting('verifyerror', 'A solicitação não pode ser validada');

        }

        /* SOME VALIDATION */

        $email = $_SESSION['email'];

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // Invalid email

            $domain = substr($email, strpos($email, '@') + 1);

            if (!checkdnsrr($domain, 'MX')) {

                errorExiting('emailerror', 'Email inválido');

            }
            
        } else {

            errorExiting('emailerror', 'Email inválido');

        }

        require __DIR__ . '/../../assets/includes/database_hub.php'; // If everything is fine at this point we can move on and connect to the database

        $C = connect(); // connection

        if ($C) {

            $r = sqlSelect($C, 'SELECT fullname FROM users WHERE email=?', 's', $email); // Checking if the email EXISTS

            if ($r && $r->num_rows === 1) {

                $usr = $r->fetch_assoc();
                $fullname = $usr['fullname'];

                $C->autocommit(FALSE);

                $selector = bin2hex(random_bytes(8));

                $utkn = _urltoken();
                $tkey   = $utkn['key'];
                $ktoken = $utkn['tkn'];
                
                $url = VERIFY_ENDPOINT . "?selector=" . $selector . "&token=" . $ktoken;

                $tsql = "INSERT INTO user_tokens (email, auth_type, token_key, keyed_token, selector, created_at) VALUES (?, ?, ?, ?, ?, DEFAULT)";

                $tid = sqlInsert($C, $tsql, 'sssss', $email, "verify", $tkey, $ktoken, $selector);

                if ($tid !== -1) {

                    include __DIR__ . '/../../assets/includes/sendmail.php';

                    //$_SESSION['STATUS']['verifystatus'] = 'Token gravado';

                    $subject = APP_NAME . ' | Verifique seu Email';

                    $mail_variables = array();

                    $mail_variables['APP_NAME'] = APP_NAME;
                    $mail_variables['fullname'] = $fullname;
                    $mail_variables['email'] = $email;
                    $mail_variables['url'] = $url;

                    $message = file_get_contents("./verif_email_template.php");

                    foreach($mail_variables as $key => $value) {
                        
                        $message = str_replace('{{ '.$key.' }}', $value, $message);

                    }

                    if (sendEmail($email, $fullname, $subject, $message)) {

                        $C->autocommit(TRUE); // END TRANSACTION (IMPLICIT COMMIT)

                        $_POST = array(); // Clear form fields

                        //$_SESSION['STATUS']['verifystatus'] = 'O email de validação de conta foi enviado';
                        header("Location: ../emailsent.php");
                        exit();

                    } else {

                        $C->rollback(); // ROLLBACK TRANSACTION
                        $C->autocommit(TRUE); 

                        errorExiting('verifyerror', 'Erro ao enviar email de validação (Mail)');

                    }

                } else {

                    $C->rollback(); // ROLLBACK TRANSACTION
                    $C->autocommit(TRUE); 

                    errorExiting('verifyerror', 'Erro ao gravar token (SQL ERROR)');

                }

            } else {

                $C->rollback(); // ROLLBACK TRANSACTION
                $C->autocommit(TRUE); 

                errorExiting('verifyerror', 'Email inválido');

            }

            //$res->free_result();
            $C->autocommit(TRUE);
        
        } else {

            errorExiting('verifyerror', 'Erro ao tentar conectar (CONN)');

        }
    
    } else {

        errorExiting('verifyerror', 'Erro com o formulário');

    }

?>