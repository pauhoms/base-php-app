<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../app/bootstrap.php';
$cors = require __DIR__ . '/cors.php';
$cors();
header('Content-Type: application/json');
$app->run();
