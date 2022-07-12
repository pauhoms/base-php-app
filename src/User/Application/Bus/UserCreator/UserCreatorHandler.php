<?php

declare(strict_types=1);

namespace User\Application\Bus\UserCreator;

use User\Application\Bus\UserQuery;
use User\Domain\ValueObjects\UserName;
use User\Domain\ValueObjects\UserPassword;
use User\Domain\Repositories\UserRepository;
use User\Application\Service\Create\UserCreator;

final class UserCreatorHandler {
    public function __construct(private readonly UserRepository $userRepository)
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
