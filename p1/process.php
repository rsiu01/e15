<?php

session_start();

$inputString = $_POST['inputString'];





function isPalindrome($inputString)
{
    if (strrev($inputString)==$inputString) {
        return 'Yes';
    } else {
        return 'No';
    }
}

function isBigWord($inputString)
{
    if (strlen($inputString) >7) {
        return 'Yes';
    } else {
        return 'No';
    }
}


function countVowel($inputString)
{
    // array to store vowels
    $vowelArray = array('A','E','I','O','U','a','e','i','o','u');

    $count = 0;
    for ($i = 0; $i < strlen($inputString); $i++) {
        if (in_array($inputString[$i], $vowelArray) == true) {
            $count++;
        }
    }
    
    return $count;
}

$isBigWordResult = isBigWord($inputString);
$isPalindromeResult = isPalindrome($inputString);
$countVowelResult = countVowel($inputString);

$_SESSION['results'] = [
    'isBigWord' => $isBigWordResult,
    'isPalindrome' => $isPalindromeResult,
    'countVowel' => $countVowelResult
    ];

header('Location: index.php');
