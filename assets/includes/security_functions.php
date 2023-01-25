<?php

    /* AUXILIARY FUNCTIONS */    

    /* used with the login attempts funcionality */
    function getIpAddress() {

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {

            $ipAddr = $_SERVER['HTTP_CLIENT_IP'];
        
        } elseif (!empty($_SERVER['HTTP_X_FORWARD_FOR'])) {
            
            $ipAddr = $_SERVER['HTTP_X_FORWARD_FOR'];
        
        } else {
            
            $ipAddr = $_SERVER['REMOTE_ADDR'];
        }
        
        return $ipAddr;

    }

	/* helps with token puzzle */
    function urlSafeEncode($m) { // avoid issues with URLs

        return rtrim(strtr(base64_encode($m), '+/', '-_'), '=');

    }
    
    /* helps with token puzzle */
    function urlSafeDecode($m) { // avoid issues with URLs

        return base64_decode(strtr($m, '-_', '+/'));

    }
        
    /* not used right now but still present since it might be useful in the future */
    function _cleaninjections($test) {

        $find = array(
            "/[\r\n]/", 
            "/%0[A-B]/",
            "/%0[a-b]/",
            "/bcc\:/i",
            "/Content\-Type\:/i",
            "/Mime\-Version\:/i",
            "/cc\:/i",
            "/from\:/i",
            "/to\:/i",
            "/Content\-Transfer\-Encoding\:/i"
        );

        $ret = preg_replace($find, "", $test);

        return $ret;

    }

    /* not used but it might be */
    function _rndstr() { // a random string
    
        $t_ = strval(rand(1462055681,1562055681));
        //$t  = time();
        $_t = strval(rand(1362055681,1462055681));

        return $t_ . md5(uniqid(mt_rand(), true)) . $_t;
        
    }


    /* "Anti" CSRF token functions */

    /* MAKE a token */
    function _mktoken() {

        /* First version
        if (!isset($_SESSION)) { // IF $_SESSION IS NOT SET, INITIALIZE IT
            session_start();
        }
        if (empty($_SESSION['_datoken'])) { // IF _datoken IS NOT SET, INITIALIZE IT
            $_SESSION['_datoken'] = _rs();
        } */

        /* Second version */
        if (!isset($_SESSION)) {

            session_start();

        }

        if (empty($_SESSION['_datoken'])) {

            $seed = urlSafeEncode(random_bytes(8));
            $t = time();
            $hash = urlSafeEncode(hash_hmac('sha256', session_id() . $seed . $t, CSRF_TOKEN_SECRET, true));
            
            $_SESSION['_datoken'] =  urlSafeEncode($hash . '|' . $seed . '|' . $t);
            
        }

    }

    /* Second Version */
    /* checks if the token is valid */
    function _cktoken() {

        _mktoken();

        if (!empty($_POST['_datoken'])) {

            $pieces = explode('|', urlSafeDecode($_POST['_datoken']));

            if(count($pieces) === 3) {

                $hash = hash_hmac('sha256', session_id() . $pieces[1] . $pieces[2], CSRF_TOKEN_SECRET, true);

                if (hash_equals($hash, urlSafeDecode($pieces[0]))) {

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

    /* insert HTML hidden input with a token */
    function _placetoken() {

        _mktoken();

        echo '<input type="hidden" name="_datoken" value="' . $_SESSION['_datoken'] . '" />';
        
    }    

    /* First Version
    function _cktoken() {

        // IF $_SESSION IS NOT SET, INITIALIZE IT
        // IF $_SESSION _datoken IS NOT SET, INITIALIZE IT
        _mktoken();

        // SINCE THIS IS COMING FROM THE REGISTER OR LOGIN FORM
        // BOTH $_SESSION AND $_SESSION _datoken ARE SET

        if (!empty($_POST['_datoken'])) { // IF $POST _datoken IS NOT EMPTY THEN

            if (hash_equals($_SESSION['_datoken'], $_POST['_datoken'])) { // IF $_SESSION _datoken EQUALS $_POST _datoken

                return true;

            } else {
                
                return false;

            }
        
        } else {

            return false;

        }
        
    } */


    /* These below help with Signing Up and Reseting Passwords */
    
    /* builts a stronger token used on the verify process */
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

    /* validates the token used on the verify process */
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

?>