<?php

namespace User\Application\Service\Create;

use User\Application\Service\Get\FindUserByName;
use User\Domain\Exceptions\UserDoesExist;
use User\Domain\Repositories\UserRepository;
use User\Domain\User;
use User\Domain\ValueObjects\UserId;
use User\Domain\ValueObjects\UserName;
use User\Domain\ValueObjects\UserPassword;

final class UserCreator {
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function __invoke(UserName $name, UserPassword $password): string
    {
        $this->userExist($name);

        $password->encryptPassword();
        $user = new User(UserId::random(), $name, $password);

        $this->userRepository->save($user);

        return $user->id()->value();
    }

    private function userExist(UserName $userName): void
    {
        $userFinder = new FindUserByName($this->userRepository);

        if (sizeof($userFinder->__invoke($userName)) !== 0)
            throw new UserDoesExist($userName);
    }
}
