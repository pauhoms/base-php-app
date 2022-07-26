<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use Shared\Domain\Bus\EventBus;
use User\Domain\Repositories\UserRepository;
use User\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;


$data = require __DIR__ . '/../configuration/database.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    EntityManager::class => $data(),
    UserRepository::class => fn($x) => new DoctrineUserRepository($data()),
    EventBus::class => fn($x) => require __DIR__ . '/rabbitMq.php',
]);

return $containerBuilder;
