<?php

    session_start();

    require __DIR__ . '/../../assets/includes/utils.php';
    require __DIR__ . '/../../assets/setup/settings.php'; 
    require __DIR__ . '/../../assets/includes/session_authorization.php';
    require __DIR__ . '/../../assets/includes/security_functions.php';

    check_if_its_logged_out(); 

    if (isset($_POST['dosend'])) {

        if (!_cktoken()) {

            errorExiting('sendresetemailerror', 'A solicitação não pode ser validada');

        }

        $email = trim($_POST['email']);

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // Invalid email

            $prefix = substr($email, 0, strrpos($email, '@'));
            $domain = substr($email, strpos($email, '@') + 1);

            if (!checkdnsrr($domain, 'MX')) {

                errorExiting('emailerror', 'Email inválido');

            }
            
        } else {

            errorExiting('emailerror', 'Email inválido');

        }

        require __DIR__ . '/../../assets/includes/database_hub.php';

        $C = connect();

        if ($C) {

            if (emailExists($C, $email)) {

                $q = 'SELECT 1 FROM user_tokens WHERE email=? AND created_at > ' . EMAIL_REQ_EXPIRY_TIME;

                $token_emails = sqlSelect($C, $q, 's', $email);

                if ($token_emails && $token_emails->num_rows >= MAX_EMAIL_REQS_PER_DAY) {

                    errorExiting('sendresetemailerror', 'Muitos emails enviados. Volte mais tarde');

                } else {
                    
                    $C->autocommit(FALSE);
                    
                    $selector = bin2hex(random_bytes(8));

                    $utkn = _urltoken();
                    $tkey   = $utkn['key'];
                    $ktoken = $utkn['tkn'];
                    
                    $url = WEB_ADDRESS . WEB_DIR .  "reset_password/index.php?selector=" . $selector . "&token=" . $ktoken;

                    $tsql = "INSERT INTO user_tokens (email, auth_type, token_key, keyed_token, selector, created_at) VALUES (?, ?, ?, ?, ?, DEFAULT)";

                    $tid = sqlInsert($C, $tsql, 'sssss', $email, "reset", $tkey, $ktoken, $selector);

                    if ($tid !== -1) {

                        require __DIR__ . '/../../assets/includes/sendmail.php';
    
                        $subject = APP_NAME . ' | Resetar sua senha';
    
                        $mail_variables = array();
    
                        $mail_variables['APP_NAME'] = APP_NAME;
                        //$mail_variables['fullname'] = $fullname;
                        $mail_variables['email'] = $email;
                        $mail_variables['url'] = $url;
    
                        $message = file_get_contents("./reset_email_template.php");
    
                        foreach($mail_variables as $key => $value) {
                            
                            $message = str_replace('{{ '.$key.' }}', $value, $message);
    
                        }
    
                        if (sendEmail($email, $prefix, $subject, $message)) {
    
                            $C->autocommit(TRUE);
    
                            $_POST = array();
    
                            //$_SESSION['STATUS']['resetstatus'] = 'O email de recuperação de senha foi enviado';
                            header("Location: ../emailsent.php");
                            exit();
    
                        } else {
    
                            $C->rollback();
                            $C->autocommit(TRUE); 
    
                            errorExiting('sendresetemailerror','Erro ao enviar email de recuperação de senha (SQL ERROR)');
    
                        }
    
                    } else {
    
                        $C->rollback();
                        $C->autocommit(TRUE); 
    
                        errorExiting('sendresetemailerror','Erro ao gravar token (SQL ERROR)');
    
                    }

                }

            } else {

                errorExiting('sendresetemailerror','Email não encontrado');

            }
        
        } else { // Conn error

            errorExiting('scripterror', 'Erro ao tentar conectar (CONN)');

        }
    
    } else { // Form error

        errorExiting('formerror', 'Erro com o formulário');

    }

?>