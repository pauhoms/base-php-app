<?php

use DI\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use User\Domain\Repositories\UserRepository;
use User\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;

function getEntityManager(): EntityManager {
    $data = require __DIR__ . '/../configuration/database.php';
    return $data();
};
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    EntityManager::class => getEntityManager(),
    UserRepository::class => function(): DoctrineUserRepository {
        return new DoctrineUserRepository(getEntityManager());
    }
]);

return $containerBuilder;
