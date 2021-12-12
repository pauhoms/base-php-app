<?php

namespace User\Application\Bus\UserCreator;

use User\Application\Service\Create\UserCreator;
use User\Domain\Repositories\UserRepository;
use User\Domain\ValueObjects\UserName;
use User\Domain\ValueObjects\UserPassword;

final class UserCreatorHandler {
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function ask(UserQuery $query): ?UserCreatorResponse
    {
        $handler = new UserCreator($this->userRepository);
        $name = new UserName($query->name());
        $password = new UserPassword($query->password());

        return new UserCreatorResponse($handler->__invoke($name, $password));
    }
}
