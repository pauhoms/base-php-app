<?php
declare(strict_types=1);

namespace Shared\Infrastructure\Persistance\Doctrine;



use User\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ObjectRepository;
use Shared\Domain\Criteria\Criteria;

abstract class DoctrineRepository
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    protected function entityManager(): EntityManager
    {
        return $this->entityManager;
    }

    protected function persist($entity): void
    {
        $this->entityManager()->persist($entity);
        $this->entityManager()->flush($entity);
    }

    protected function remove($entity): void
    {
        $this->entityManager()->remove($entity);
        $this->entityManager()->flush($entity);
    }

    protected function createQueryBuilder(): QueryBuilder
    {
        return $this->entityManager->createQueryBuilder();
    }

    protected function repository(): EntityRepository
    {
        return $this->entityManager->getRepository($this->getClass());
    }

    protected function searchByCriteria(Criteria $criteria)
    {
        $doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);

        return $this->repository()
            ->createQueryBuilder('u')
            ->addCriteria($doctrineCriteria)
            ->getQuery()
            ->getResult();
    }

    protected abstract function getClass(): string;
}
