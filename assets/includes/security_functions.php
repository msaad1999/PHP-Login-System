<?php

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

