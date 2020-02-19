<?php

$answer = $_POST['answer'];

if ($answer == 'pumpkim'){
    $result = 'Correct!';
}
else {
    $result = 'Incorrect!';
}

require 'process-view.php';