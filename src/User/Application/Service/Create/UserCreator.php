<?php

namespace User\Application\Service\Create;

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
        $password->encryptPassword();
        $user = new User(UserId::random(), $name, $password);

        $this->userRepository->save($user);

        return $user->id()->value();
    }
}
