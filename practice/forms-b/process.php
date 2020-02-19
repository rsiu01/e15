<?php

session_start();

$answer = $_POST['answer'];

if ($answer == 'pumpkim'){
    $results = 'Correct!';
}
else {
    $results = 'Incorrect!';
}

$_SESSION['results'] = $results;

# Redirect
header('Location: done.php');
