<?php

declare(strict_types=1);

namespace User\Application\Bus\UserAuthenticator;

use Shared\Domain\Bus\QueryHandler;
use User\Application\Bus\UserQuery;
use User\Application\Service\Get\UserAuthenticator;
use User\Domain\Repositories\UserRepository;
use User\Domain\ValueObjects\UserName;
use User\Domain\ValueObjects\UserPassword;

final class UserAuthenticationHandler implements QueryHandler
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    /**
     * @param UserQuery $query
     * @return UserAuthenticatorResponse
     */
    public function ask($query): UserAuthenticatorResponse
    {
        $handler = new UserAuthenticator($this->userRepository);

        $name = new UserName($query->name());
        $password = new UserPassword($query->password());

        return new UserAuthenticatorResponse($handler->__invoke($name, $password));
    }
}
