<?php
declare(strict_types=1);

namespace Tests\Unit\Shared\Infrastructure;


use DI\Container;
use DI\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

abstract class IntegrationTestCase extends TestCase
{
    protected function getEntityManager(): EntityManager
    {
        $data = require __DIR__ . '/../../../../app/configuration/database.php';
        $entityManager = $data();
        $entityManager->getConnection()->connect();

        return $entityManager;
    }

    protected function getContainer(): Container
    {
        /** @var ContainerBuilder $containerBuilder */
        $containerBuilder = require __DIR__ . '/../../../../app/configuration/container.php';

        return $containerBuilder->build();
    }
}
