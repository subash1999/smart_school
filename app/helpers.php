<?php
function getShortFormOfSentence($sentence){
    $words = preg_split("/[\s,_-]+/", $sentence);
    $acronym = "";
    foreach ($words as $w) {
        $acronym .= $w[0];
    }
    return $acronym;
}


