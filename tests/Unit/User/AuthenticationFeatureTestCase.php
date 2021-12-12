<?php

namespace Tests\Unit\User;

use Tests\Unit\Shared\FeatureTestCase;
use Slim\App;

abstract class AuthenticationFeatureTestCase extends FeatureTestCase
{
    function getAppInstance(): App
    {
        return require __DIR__ . '/../../app/bootstrap.php';
    }
}