<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('/api', function (RouteCollectorProxy $group) {
        $group->get('/health-check', 'App\Controllers\HealthCheck');

        $group->group('/user', function (RouteCollectorProxy $group) {
            $group->get('/authenticate', 'App\Controllers\User\Get\UserAuthenticatorController');
            $group->post('/create', 'App\Controllers\User\Create\UserCreatorController');
        })->add('App\Middleware\ErrorHandler');
    });
};
