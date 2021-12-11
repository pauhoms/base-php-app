<?php

use Slim\Factory\AppFactory;


$containerBuilder = require __DIR__ . '/configuration/container.php';


AppFactory::setContainer($containerBuilder->build());
$app = AppFactory::create();

$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$routes = require __DIR__ . '/configuration/routes.php';
$routes($app);

return $app;