<?php

declare(strict_types=1);

use Slim\App;
use Slim\Routing\RouteCollectorProxy;


return function (App $app) {
    $app->group('/api', function (RouteCollectorProxy $group) {
        $group->get('/health-check', 'App\Controllers\HealthCheck');

        $userRoutes = require __DIR__ . '/user.routes.php';
        $userRoutes($group);
    })->add('App\Middleware\ErrorHandler');
};
