<?php

function shortenText($text, $max = 200) {
    $string = strlen($text) > $max ? substr($text, 0, $max).'...' : $text;
    return $string;
}
