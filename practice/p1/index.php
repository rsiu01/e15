<?php

function isPalindrome($inputString)
{
    if (strrev($inputString)==$inputString){
        return true;
    }
}

$vowelArray = [
    'A',
    'E',
    'I',
    'O',
    'U',
    'a',
    'e',
    'i',
    'o',
    'u',
];

function Vowel_Count($inputString)
{
    $count = 0;
    for($i = 0; $i < strlen($inputString); $i++)
        if (in_array($inputString[i],$vowelArray) == true)
            $count++;
    
    return $count;

}



require 'index-view.php';