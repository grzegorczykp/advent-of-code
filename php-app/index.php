<?php
require_once __DIR__ . '/vendor/autoload.php';

$assigment = new App2023\Assignments\Day3();
$result = $assigment->run();

echo 'Task 1: ' . $result[0] . '<br>';
echo 'Task 2: ' . $result[1];
