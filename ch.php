<?php

//@sdm15 alwasys bring simple challenges :P

function getOccurance( $num, $needle){
    $num = (string) $num;
    $needle = (string) $needle;

    preg_match_all('/'.$needle.'/', $num, $matches);

    return count($matches[0]);
}

echo getOccurance(1468984638946, 46);