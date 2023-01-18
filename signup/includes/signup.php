<?php

    session_start();

    require __DIR__ . '/../../assets/setup/settings.php'; 
    require __DIR__ . '/../../assets/includes/session_authorization.php';
    require __DIR__ . '/../../assets/includes/security_functions.php';

    check_if_its_logged_out(); // If there is any authorization redirects to home. Otherwise, does nothing (stay here).

    function signupErrorExiting($var, $msg) {

        $_SESSION['ERRORS'][$var] = $msg;
        header("Location: ../");
        exit();

    }    

    if (isset($_POST['dosignup'])) {

        if (!_cktoken()) {

            signupErrorExiting('signuperror', 'A solicitação não pode ser validada');

        }

        /* SOME VALIDATION */
        
        $fullname       = preg_replace('/\s{2,}/', ' ', trim($_POST['fullname'])); // Removing double whitespaces such and such
        $phone          = trim($_POST['phone']);
        $email          = trim($_POST['email']);
        $instagram      = trim($_POST['instagram']);
        $password       = trim($_POST['pwd']);
        $passwordRepeat = trim($_POST['cpwd']);

        /* Looking for brazilian portuguese names here. Additionally, a single quote is allowed. */
        if (strlen($fullname) <= 2 || strlen($fullname) > 40 || !preg_match("/^[a-zA-Z-ÇçÑñÁÉÍÓÚáéíóúÃÕãõÂÊÔâêôÈèöÖ \']*$/", $fullname)) { // Invalid PT BR name
                
            signupErrorExiting('fullnameerror','Nome completo inválido');

        }

        //if (!preg_match("^(?:(?:\+|00)?(55)\s?)?(?:\(?([1-9][0-9])\)?\s?)(?:((?:9\d|[2-9])\d{3})\-?(\d{4}))$", $phone)) {
        // Only numbers, parentesis and dash are allowed. Min 8 and max 20
        // Accepted formats are (00) x0000-0000 and (00) 0000-0000
        if (strlen($phone) <= 8 || strlen($phone) > 20 || !preg_match("/^\([0-9]{2}\) [0-9]?[0-9]{4}-[0-9]{4}$/", $phone)) { // Invalid phone number

            signupErrorExiting('phoneerror','Telefone inválido');         
        
        }

        // At first the Instagram username has to be a string, then it has to match Instagram standards (as of 2022)
        if (!preg_match("/^[\w](?!.*?\.{2})[\w.]{1,28}[\w]$/", $instagram)) { // Invalid Instagram

            signupErrorExiting('instagramerror','Instagram inválido');

        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Invalid email

            signupErrorExiting('emailerror','Email inválido');
            
        } else { // Email domain could not be checked
            
            if (!checkdnsrr(substr($email, strpos($email, '@') + 1), 'MX')) {

                signupErrorExiting('emailerror','Email inválido');

            }
        
        }

        // Password must have letters, numbers, special characters and be 8 characters long
        //} else if ( !isset($password) || preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\~?!@#\$%\^&\*])(?=.{8,})/', $password) ) {
        // Password must have letters and numbers and have at least 8 characters and less than 41 characters long
        if (!isset($password) || preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,40})/', $password) ) { // Weak password

            signupErrorExiting('passworderror','A senha deve ter letras, números e no mínimo 8 caracteres');

        } else { // Passwords dont match

            if ($password !== $passwordRepeat) {

                signupErrorExiting('passworderror','As senhas não são iguais');

            }

        }
        
        require __DIR__ . '/../../assets/includes/database_hub.php'; // If everything is fine at this point we can move on and connect to the database

        $C = connect(); // connection

        if ($C) { // Returns true or false

            $r = sqlSelect($C, 'SELECT 1 FROM users WHERE email=?', 's', $email); // Checking if the email IS NOT TAKEN

            if ($r && $r->num_rows === 0) {
                
                $C->autocommit(FALSE); // BEGIN TRANSACTION

                $usql = "INSERT INTO users (fullname, phone, instagram, email, pwd, created_at, last_login_at) VALUES (?, ?, ?, ?, ?, NOW(), NULL)";

                $uid = sqlInsert($C, $usql, 'sssss', $fullname, $phone, $instagram, $email, password_hash($password, PASSWORD_DEFAULT));

                if ($uid !== -1) { //$_SESSION['STATUS']['signupstatus'] = 'Novo usuário gravado';                    

                    $selector = bin2hex(random_bytes(8));

                    $utkn = _urltoken();    // This function generates a pair of a key and a token.
                    $tkey   = $utkn['key']; // The key will be saved on the database
                    $ktoken = $utkn['tkn']; // The token will be sent in the URL (also stored on the database just for reference)
            
                    $url = VERIFY_ENDPOINT . "?selector=" . $selector . "&token=" . $ktoken;
        
                    $tsql = "INSERT INTO user_tokens (email, auth_type, token_key, keyed_token, selector, created_at) VALUES (?, ?, ?, ?, ?, DEFAULT)";
        
                    $tid = sqlInsert($C, $tsql, 'sssss', $email, "signup", $tkey, $ktoken, $selector);

                    if ($tid !== -1) { //$_SESSION['STATUS']['signupstatus'] = 'Novo usuário e token gravados';

                        include($_SERVER['DOCUMENT_ROOT'] . '/supabkp/assets/includes/sendmail.php'); // IS THIS ANY BETTER THAN __DIR__ ?                        
       
                        $subject = 'Shop2pacK | Verifique seu Email';
        
                        $mail_variables = array();
        
                        $mail_variables['APP_NAME'] = APP_NAME;
                        $mail_variables['fullname'] = $fullname;
                        $mail_variables['email'] = $email;
                        $mail_variables['url'] = $url;
        
                        $message = file_get_contents("./signup_email_template.php");
        
                        foreach($mail_variables as $key => $value) {
                            
                            $message = str_replace('{{ '.$key.' }}', $value, $message);
        
                        }
        
                        if (sendEmail($email, $fullname, $subject, $message)) { //$_SESSION['STATUS']['signupstatus'] = 'Novo usuário e token gravados e email de validação enviado';
                            
                            $C->autocommit(TRUE); // END TRANSACTION (IMPLICIT COMMIT)

                            $_POST = array(); // Clear form fields, not sure if I need this since there is a header/exit right below        
                            
                            header("Location: ../success.php");
                            exit();
        
                        } else { // Send mail error

                            $C->rollback(); // ROLLBACK TRANSACTION
                            $C->autocommit(TRUE);                            
        
                            signupErrorExiting('scripterror','Erro ao enviar email de validação (SENDMAIL ERROR). Sua conta não foi cadastrada');
        
                        }
                
                    } else { // DML error (INSERT on USER_TOKENS)

                        $C->rollback(); // ROLLBACK TRANSACTION
                        $C->autocommit(TRUE);                        
        
                        signupErrorExiting('scripterror','Erro ao gravar token (DML ERROR). Sua conta não foi cadastrada');
        
                    }

                } else { // DML error (INSERT on USERS)

                    $C->rollback(); // ROLLBACK TRANSACTION
                    $C->autocommit(TRUE);                    

                    signupErrorExiting('scripterror','Erro ao cadastrar nova conta (DML ERROR)');

                }
                
                //$res->free_result();
                $C->autocommit(TRUE);

            } else { // Email taken

                signupErrorExiting('emailerror','Email já cadastrado');

            }
        
        } else { // Conn error

            signupErrorExiting('scripterror','Erro ao tentar conectar (Connection ERROR)');

        }
    
    } else { // Form error

        signupErrorExiting('formerror','Erro com o formulário');

    }

?>