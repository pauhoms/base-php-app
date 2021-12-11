<?php
declare(strict_types=1);

namespace Authentication\Infrastructure\Persistence\Doctrine;


use Authentication\Domain\User;
use Authentication\Domain\ValueObjects\UserId;
use Authentication\Domain\ValueObjects\UserName;
use Authentication\Domain\ValueObjects\UserPassword;
use Doctrine\Common\Collections\Criteria as DoctrineCriteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\DBAL\Schema\Comparator;
use Shared\Domain\Criteria\Criteria;
use Shared\Infrastructure\Persistance\Doctrine\DoctrineCriteriaConverter;
use Shared\Infrastructure\Persistance\Doctrine\DoctrineRepository;

final class DoctrineUserRepository extends DoctrineRepository
{
    public function save(User $user): void
    {
        $this->persist($user);
    }

    public function all(): array
    {
        return $this->repository()->findAll();
    }

    public function findById(UserId $userId): ?object
    {
        return $this->repository()->find($userId);
    }

    public function search(Criteria $criteria)
    {
        return $this->searchByCriteria($criteria);
    }

    protected function getClass(): string
    {
        return User::class;
    }
}
