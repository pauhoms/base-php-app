<?php

use DI\ContainerBuilder;
use Doctrine\ORM\EntityManager;


$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    EntityManager::class => function() {
        $data = require __DIR__ . '/../configuration/database.php';
        return $data();
    }
]);

return $containerBuilder;
