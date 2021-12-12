<?php
declare(strict_types=1);

namespace Tests\Unit\User\Shared;


use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

abstract class DoctrineTestCase extends TestCase
{
    protected function getEntityManager(): EntityManager
    {
        $data = require __DIR__ . '/../../../../app/configuration/database.php';
        $entityManager = $data();
        $entityManager->getConnection()->connect();

        return $entityManager;
    }
}
