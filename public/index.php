<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../app/bootstrap.php';

header('Content-Type: application/json');
$app->run();
