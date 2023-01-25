<?php

    session_start();

    function urlSafeEncode($m) {

        return rtrim(strtr(base64_encode($m), '+/', '-_'), '=');

    }

    function urlSafeDecode($m) {

        return base64_decode(strtr($m, '-_', '+/'));

    }

    $key = urlSafeEncode(random_bytes(4)); // OK
    //$key = "ogirdor"; // OK

    $rnd = urlSafeEncode(random_bytes(8)); // OK

    $whn = time();

    //$hsh = urlSafeEncode(hash_hmac('sha256', session_id() . $rnd . $whn, $key, true));
    $hsh = urlSafeEncode(hash_hmac('sha384', $rnd . $whn, $key, true));

    $tkn = urlSafeEncode($hsh . '|' . $rnd . '|' . $whn);

    echo "key: |" . $key . "|<br>";

    echo "Randon Bytes: |" . $rnd . "|<br>";
    
    echo "When (time): |" . $whn . "|<br>";
    
    //echo "session_id: |" . session_id() . "|<br>";
    
    echo "Hash (sha256 using the key to scramble session_id + random bytes + time1): |" . $hsh . "|<br>";
    
    echo "token 3 PIECES (urlSafeEncode o hash | random bytes | time): |" . $tkn . "|<br>";

    echo "<br>";
    echo "<br>";

    $pieces = explode('|', urlSafeDecode($tkn));

    if(count($pieces) === 3) {
        
        echo "TOKEN PIECES <br>";
        echo "piece 0 (hsh): " . $pieces[0] . "<br>";
        echo "piece 1 (rnd): " . $pieces[1] . "<br>";
        echo "piece 2 (whn): " . $pieces[2] . "<br>";

        //$z = hash_hmac('sha256', $pieces[0] . $pieces[1] . $pieces[2], $key, true);
        $z = hash_hmac('sha384', $pieces[1] . $pieces[2], $key, true);

        echo "z: |" . $z . "|";

        if (hash_equals($z, urlSafeDecode($pieces[0]))) {

            echo "true";

        } else { 

            echo "false"; // the token could not be "un" hashed

        } 

    } else {
        echo "tkn does not have 3 pieces";
    }

    function _urltoken() {

        $_key = urlSafeEncode(random_bytes(4));        
        $_str = urlSafeEncode(random_bytes(8));
        $_when = time();
        
        $_hash = urlSafeEncode(hash_hmac('sha384', $_str . $_when, $_key, true));

        $_tkn = urlSafeEncode($_hash . '|' . $_str . '|' . $_when);        
        
        $_arr['key'] = $_key;
        $_arr['tkn'] = $_tkn;

        return $_arr;

    }

    function _ckurltoken($_key, $_tkn) {

        if (!empty($_key) && !empty($_tkn)) {

            $_pieces = explode('|', urlSafeDecode($_tkn));

            if(count($_pieces) === 3) {

                $_hash = hash_hmac('sha384', $_pieces[1] . $_pieces[2], $_key, true);

                if (hash_equals($_hash, urlSafeDecode($_pieces[0]))) {

                    return true;

                } else { 

                    return false; // the token could not be "un" hashed

                }            

            } else {

                return false; // the token does not have 3 pieces

            }

        } else {

            return false; // there is no POST token

        }

		return false; // if it gets here it means no true conditions were met

    }

    $urltoken = _urltoken();
    echo "<br>";
    echo $urltoken['key'] . "<br>";
    echo $urltoken['tkn'] . "<br>";

    if (_ckurltoken($urltoken['key'], $urltoken['tkn'])) {
        echo "true" . "<br>";
    } else {
        echo "false" . "<br>";
    }

?>