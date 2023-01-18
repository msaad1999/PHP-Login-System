<?php

    session_start();

    require __DIR__ . '/../../assets/setup/settings.php'; 
    require __DIR__ . '/../../assets/includes/session_authorization.php';
    require __DIR__ . '/../../assets/includes/security_functions.php';

    check_if_its_logged_in_but_its_not_verified(); // If $_SESSION['authorization'] is Verified redirect to HOME, 
                                                   // if it's just loggedIn do nothing (user must verify email in some way)
                                                   // and if it's not set redirect to LOGIN.

    if (isset($_POST['doverify'])) {

        // foreach ($_POST as $key => $value) { $_POST[$key] = _cleaninjections(trim($value)); }

        if (!_cktoken()) { // ERRORS, verifystatus

            $_SESSION['ERRORS']['verifystatus'] = 'A solicitação não pode ser validada.';
            header("Location: ../");
            exit();

        }

        /* VERIFY VALIDATION */

        $email = $_SESSION['email'];

        // e-Mail has to be validated as well
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $_SESSION['ERRORS']['emailerror'] = 'Email inválido';
            header("Location: ../");
            exit();
            
        } else {
            
            // and then the domain is checked as well
            if (!checkdnsrr(substr($email, strpos($email, '@') + 1), 'MX')) {

                $_SESSION['ERRORS']['emailerror'] = 'Email inválido';
                header("Location: ../");
                exit();

            }
        
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

                    include($_SERVER['DOCUMENT_ROOT'] . '/supabkp/assets/includes/sendmail.php'); // IS THIS ANY BETTER THAN __DIR__ ?

                    //$_SESSION['STATUS']['verifystatus'] = 'Token gravado';

                    $subject = 'Shop2pacK | Verifique seu Email';

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

                        $_SESSION['STATUS']['verifystatus'] = 'O email de validação de conta foi enviado';
                        header("Location: ../emailsent.php");
                        exit();

                    } else {

                        $C->rollback(); // ROLLBACK TRANSACTION
                        $C->autocommit(TRUE); 

                        $_SESSION['ERRORS']['verifyerror'] = 'Erro ao enviar email de validação (SQL ERROR)';
                        header("Location: ../");
                        exit();

                    }

                } else {

                    $C->rollback(); // ROLLBACK TRANSACTION
                    $C->autocommit(TRUE); 

                    $_SESSION['ERRORS']['verifyerror'] = 'Erro ao gravar token (SQL ERROR)';
                    header("Location: ../");
                    exit();

                }

            } else {

                $C->rollback(); // ROLLBACK TRANSACTION
                $C->autocommit(TRUE); 

                $_SESSION['ERRORS']['verifyerror'] = 'Email não encontrado';
                header("Location: ../");
                exit();

            }

            //$res->free_result();
            $C->autocommit(TRUE);
        
        } else {

            $_SESSION['ERRORS']['verifyerror'] = 'Erro ao gravar token (Connection ERROR)';
            header("Location: ../");
            exit();

        }
    
    } else {

        // MAYBE HTML FORM ERROR
        header("Location: ../");
        exit();

    }

?>