<?php

    session_start();

    require __DIR__ . '/../../assets/setup/settings.php'; 
    require __DIR__ . '/../../assets/includes/session_authorization.php';
    require __DIR__ . '/../../assets/includes/security_functions.php';

    check_if_its_logged_out();

    function resetErrorExiting($var, $msg) {

        $_SESSION['ERRORS'][$var] = $msg;
        header("Location: ../");
        exit();

    }  

    if (isset($_POST['dosend'])) {

        if (!_cktoken()) {

            resetErrorExiting('sendresetemailerror', 'A solicitação não pode ser validada');

        }

        $email = trim($_POST['email']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            resetErrorExiting('sendresetemailerror','Email inválido');
            
        } else {
            
            if (!checkdnsrr(substr($email, strpos($email, '@') + 1), 'MX')) {

                resetErrorExiting('sendresetemailerror','Email inválido');

            }
        
        }

        require __DIR__ . '/../../assets/includes/database_hub.php';

        $C = connect();

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
                
                $url = RESET_ENDPOINT . "?selector=" . $selector . "&token=" . $ktoken;

                $tsql = "INSERT INTO user_tokens (email, auth_type, token_key, keyed_token, selector, created_at) VALUES (?, ?, ?, ?, ?, DEFAULT)";

                $tid = sqlInsert($C, $tsql, 'sssss', $email, "reset", $tkey, $ktoken, $selector);

                if ($tid !== -1) {

                    include($_SERVER['DOCUMENT_ROOT'] . '/supabkp/assets/includes/sendmail.php');

                    $subject = 'Shop2pacK | Resetar sua senha';

                    $mail_variables = array();

                    $mail_variables['APP_NAME'] = APP_NAME;
                    $mail_variables['fullname'] = $fullname;
                    $mail_variables['email'] = $email;
                    $mail_variables['url'] = $url;

                    $message = file_get_contents("./reset_email_template.php");

                    foreach($mail_variables as $key => $value) {
                        
                        $message = str_replace('{{ '.$key.' }}', $value, $message);

                    }

                    if (sendEmail($email, $fullname, $subject, $message)) {

                        $C->autocommit(TRUE);

                        $_POST = array();

                        $_SESSION['STATUS']['resetstatus'] = 'O email de recuperação de senha foi enviado';
                        header("Location: ../emailsent.php");
                        exit();

                    } else {

                        $C->rollback();
                        $C->autocommit(TRUE); 

                        resetErrorExiting('sendresetemailerror','Erro ao enviar email de recuperação de senha (SQL ERROR)');

                    }

                } else {

                    $C->rollback();
                    $C->autocommit(TRUE); 

                    resetErrorExiting('sendresetemailerror','Erro ao gravar token (SQL ERROR)');

                }

            } else {

                $C->rollback();
                $C->autocommit(TRUE); 

                resetErrorExiting('sendresetemailerror','Email não encontrado');

            }

            $C->autocommit(TRUE);
        
        } else {

            resetErrorExiting('sendresetemailerror','Erro ao gravar token (Connection ERROR)');

        }
    
    } else {

        signupErrorExiting('sendresetemailerror','Erro com o formulário');

    }

?>