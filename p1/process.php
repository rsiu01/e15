<?php

require 'StringProcessor.php';

session_start();

$inputString = $_POST['inputString'];

$stringProcessor = new StringProcessor($inputString);





$isBigWordResult = $stringProcessor->isBigWord();
$isPalindromeResult = $stringProcessor->isPalindrome();
$countVowelResult = $stringProcessor->countVowel();

$_SESSION['results'] = [
    'isBigWord' => $isBigWordResult,
    'isPalindrome' => $isPalindromeResult,
    'countVowel' => $countVowelResult
    ];

header('Location: index.php');
