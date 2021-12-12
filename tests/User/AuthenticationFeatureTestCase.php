<?php

namespace Tests\User;

use Tests\Shared\FeatureTestCase;
use Slim\App;

abstract class AuthenticationFeatureTestCase extends FeatureTestCase
{
    function getAppInstance(): App
    {
        return require __DIR__ . '/../../app/bootstrap.php';
    }
}