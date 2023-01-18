<?php

    require_once '../../assets/includes/dhub.php';
    require_once '../../assets/setup/nfo.php';
    require_once '../../assets/includes/utils.php';

    // hardcoded
    $email = 'rodrigo.rodriguessp@gmail.com';

    echo '<pre>';

    $C = connect();

    if ($C) {

        $oneDayAgo = time() - 60 * 60 *24;
        
        $res = sqlSelect($C, 'SELECT u.id, u.fullname, u.verified FROM usrs u, auth_tokens v where u.id = v.usr_id');

        if ($res && $res->num_rows == 1) {

            //print_r($res);
            //print_r($res->fetch_assoc());

            // REMEMBER, this is an array.
            $user = $res->fetch_assoc();

            // not ideal. Business rules should not be hardcoded
            if ($user['verified'] == 0) {

                // Lets check how many attempts
                if ($user['COUNT(requests.id'] < MAX_EMAIL_VERIFICATION_REQUESTS_PER_DAY) {
                    
                    $verifyCode = random_bytes(16);
                    $hash = password_hash($verifyCode, PASSWORD_DEFAULT);                    
                    
                    $id = sqlInsert($C, 'INSERT INTO requests or auth_tokens', $user['id'], $hash);

                    if ($id != -1) {

                        // send email
                        if ()


                    } else {

                        echo 'failed to insert into auth_tokens/requests';

                    }


                } else {

                    echo 'TOO MANY IN ONE DAY';
                    
                }

            } else {

                echo 'already verified';

            }

            $res->free_result();

        } else {

            echo 'no user with that email'; // we could NOT find an user with that email

        }

        $C->close();

    } else {

        echo 'can not connect';

    }

?>