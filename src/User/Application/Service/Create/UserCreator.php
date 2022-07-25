<?php

declare(strict_types=1);

namespace User\Application\Service\Create;

use User\Domain\Exceptions\UserDoesExist;
use User\Domain\Repositories\UserRepository;
use User\Domain\Services\FindUserByName;
use User\Domain\User;
use User\Domain\ValueObjects\UserId;
use User\Domain\ValueObjects\UserName;
use User\Domain\ValueObjects\UserPassword;

final class UserCreator {
    public function __construct(private readonly UserRepository $userRepository) {}

    public function __invoke(UserId $userId, UserName $name, UserPassword $password): void
    {
        $this->userExist($name);
        $user = User::create($userId, $name, $password);

        $this->userRepository->save($user);
    }

    private function userExist(UserName $userName): void
    {
        $userFinder = new FindUserByName($this->userRepository);

        if ($userFinder($userName) !== null)
            throw new UserDoesExist($userName);
    }
}
