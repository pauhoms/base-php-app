<?php

declare(strict_types=1);

use Slim\Routing\RouteCollectorProxy;

return function (RouteCollectorProxy $group) {
    $group->group('/user', function (RouteCollectorProxy $group) {
        $group->get('/authenticate', 'App\Controllers\User\Get\UserAuthenticatorController');
        $group->post('/create', 'App\Controllers\User\Create\UserCreatorController');
    });
};
