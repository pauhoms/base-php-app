<?php

namespace User\Infrastructure\Persistence;

use Shared\Domain\Criteria\Criteria;
use Shared\Infrastructure\Persistance\BaseFakeRepository;
use User\Domain\Repositories\UserRepository;
use User\Domain\User;
use User\Domain\ValueObjects\UserId;

final class FakeUserRepository extends BaseFakeRepository implements UserRepository
{
    public function __construct(array $value = [])
    {
        parent::__construct($value);
    }

    public function save(User $user): void
    {
        $this->add($user);
    }

    public function all(): array
    {
        return $this->get();
    }

    public function findById(UserId $userId): ?User
    {
        return isset($this->get()[0]) ? $this->get()[0] : null;
    }

    public function search(Criteria $criteria): array
    {
        if ($criteria->filters()->filters()[0]->value()->value() === "test")
            return $this->get();

        return [];
    }
}