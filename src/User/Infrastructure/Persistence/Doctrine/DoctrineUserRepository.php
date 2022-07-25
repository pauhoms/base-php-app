<?php
declare(strict_types=1);

namespace User\Infrastructure\Persistence\Doctrine;


use User\Domain\User;
use User\Domain\ValueObjects\UserId;
use Shared\Domain\Criteria\Criteria;
use Shared\Infrastructure\Persistance\Doctrine\DoctrineRepository;
use User\Domain\Repositories\UserRepository;

final class DoctrineUserRepository extends DoctrineRepository implements UserRepository
{
    public function save(User $user): void
    {
        $this->persist($user);
    }

    public function all(): array
    {
        return $this->repository()->findAll();
    }

    public function findById(UserId $userId): ?User
    {
        return $this->repository()->find($userId);
    }

    public function searchOne(Criteria $criteria): ?User
    {
        return $this->searchOneByCriteria($criteria);
    }

    /** @return User[] */
    public function search(Criteria $criteria): array
    {
        return $this->searchByCriteria($criteria);
    }

    protected function getClass(): string
    {
        return User::class;
    }
}
