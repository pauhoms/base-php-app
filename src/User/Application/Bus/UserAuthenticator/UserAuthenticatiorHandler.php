<?php

namespace User\Application\Bus\UserAuthenticator;

use User\Application\Bus\UserAuthenticator\UserAuthenticatorResponse;
use User\Application\Bus\UserQuery;
use User\Application\Service\Get\UserAuthenticator;
use User\Domain\Repositories\UserRepository;
use User\Domain\ValueObjects\UserName;
use User\Domain\ValueObjects\UserPassword;

final class UserAuthenticatiorHandler
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function ask(UserQuery $query): UserAuthenticatorResponse
    {
        $handler = new UserAuthenticator($this->userRepository);

        $name = new UserName($query->name());
        $password = new UserPassword($query->password());

        return new UserAuthenticatorResponse($handler->__invoke($name, $password));
    }
}
