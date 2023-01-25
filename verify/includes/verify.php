<?php

    session_start();

    require __DIR__ . '/../../assets/includes/utils.php';
    require __DIR__ . '/../../assets/setup/settings.php'; 
    require __DIR__ . '/../../assets/includes/session_authorization.php';
    require __DIR__ . '/../../assets/includes/security_functions.php';

    // needless to check if it is loggedout

    if (isset($_GET['selector']) && isset($_GET['token'])) {

        $uselector = $_GET['selector']; // Extract selector and token from URL
        $utoken    = $_GET['token'];

        if (strlen($uselector) > 16 || strlen($utoken) > 116) {

            errorExiting('verifyerror', 'Token inválido (5). Faça o login no sistema e tente enviar o email de validação novamente');

        }

        require __DIR__ . '/../../assets/includes/database_hub.php';

        $C = connect();

        if ($C) {

            // Check if the URL was sent before EXPIRY TIME (created_at column is a MySQL timestamp datatype)
            $q = "SELECT email, auth_type, token_key from user_tokens WHERE selector=? and created_at > " . TOKEN_EXPIRY_TIME;
            
            $r = sqlSelect($C, $q, 's', $uselector);

            if ($r && $r->num_rows === 1) {

                $t = $r->fetch_assoc();

                if (_ckurltoken($t['token_key'], $utoken)) {

                    if (recordUserWasVerified($C, $t['email'])) { // TOKEN OK, it'll be redirected to login

                        $_SESSION['STATUS']['verifystatus'] = 'Seu email foi verificado. Você pode fazer o login no sistema.';

                        header ("Location: ../../login/");

                    } else { // Verification was not recorded

                        errorExiting('verifyerror', 'Token inválido (4). Faça o login no sistema e tente enviar o email de validação novamente');

                    }

                } else { // Token could not be validated with key

                    errorExiting('verifyerror', 'Token inválido (3). Faça o login no sistema e tente enviar o email de validação novamente');

                }

            } else { // Token Selector could not be found

                errorExiting('verifyerror', 'Token inválido (2). Faça o login no sistema e tente enviar o email de validação novamente');

            }
    
        } else { // Database connection error

            errorExiting('verifyerror', 'Erro ao tentar conectar (CONN)');

        }

    } else { // Some issue with the URL

        errorExiting('verifyerror', 'Token inválido (1). Faça o login no sistema e tente enviar o email de validação novamente');

    }

?>