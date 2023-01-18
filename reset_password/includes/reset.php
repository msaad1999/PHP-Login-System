<?php

    session_start();

    require __DIR__ . '/../../assets/setup/settings.php'; 
    require __DIR__ . '/../../assets/includes/session_authorization.php';
    require __DIR__ . '/../../assets/includes/security_functions.php';

    check_if_its_logged_out();

    function resetErrorExiting($msg) {

        $_SESSION['ERRORS']['resetpassworderror'] = $msg;
        header("Location: ../");
        exit();

    }

    if (isset($_POST['doreset'])) {

        if (!_cktoken()) {

            resetErrorExiting('A solicitação não pode ser validada (dTKN)');

        }

        /* SOME VALIDATION */

        $uselector = $_POST['selector']; // Extract selector and token from URL
        $utoken = $_POST['token'];

        if (strlen($uselector) > 16) {

            resetErrorExiting('Tente enviar o email para recuperar a senha novamente (uSEL)');

        }

        if (strlen($utoken) > 116) {

            resetErrorExiting('Tente enviar o email para recuperar a senha novamente (uTKN)');

        }

        $password       = trim($_POST['pwd']);
        $passwordRepeat = trim($_POST['cpwd']);


        // Password must have letters and numbers and have at least 8 characters and less than 41 characters long
        if (!isset($password) || preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,40})/', $password) ) { // Weak password

            resetErrorExiting('A senha deve ter letras, números e no mínimo 8 caracteres');

        } else { // Passwords dont match

            if ($password !== $passwordRepeat) {

                resetErrorExiting('As senhas não são iguais');

            }

        }

        require __DIR__ . '/../../assets/includes/database_hub.php';

        $C = connect();

        if ($C) {

            // Check if the URL was sent before EXPIRY TIME (created_at is a MySQL timestamp datatype)
            $q = "SELECT email, auth_type, token_key from user_tokens WHERE selector=? and created_at>" . TOKEN_EXPIRY_TIME; // DATE_SUB(now(), interval 3 hour)
            $r = sqlSelect($C, $q, 's', $uselector);

            if ($r && $r->num_rows === 1) {

                $t = $r->fetch_assoc();

                if (_ckurltoken($t['token_key'], $utoken)) {

                    if (recordUserNewPassword($C, $t['email'], password_hash($password, PASSWORD_DEFAULT))) {

                        $_POST = array();

                        $_SESSION['STATUS']['resetstatus'] = 'Senha alterada. Você pode fazer o login no sistema.';
                        header ("Location: ../../login/");

                    } else {

                        resetErrorExiting('Tente enviar o email para recuperar a senha novamente (UPDT)');

                    }

                } else { // Token could not be validated with key

                    resetErrorExiting('Tente enviar o email para recuperar a senha novamente (INVALID TKN)');

                }

            } else { // Token Selector could not be found

                resetErrorExiting('Tente enviar o email para recuperar a senha novamente (TKN NOT FOUND)');

            }

        } else { // Database connection error

            resetErrorExiting('Erro ao tentar conectar (Connection ERROR)');

        }

    } else { // Form error

        resetErrorExiting('Tente enviar o email para recuperar a senha novamente (FORM)');

    }

?>