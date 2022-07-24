<?php

declare(strict_types=1);

namespace User\Application\Bus\UserCreator;

use Shared\Domain\Bus\QueryHandler;
use User\Application\Bus\UserQuery;
use Shared\Domain\Bus\Query;
use User\Domain\ValueObjects\UserName;
use User\Domain\ValueObjects\UserPassword;
use User\Domain\Repositories\UserRepository;
use User\Application\Service\Create\UserCreator;

final class UserCreatorHandler implements QueryHandler {
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    /**
     * @param UserQuery $query
     * @return UserCreatorQueryResponse|null
     */
    public function ask($query): ?UserCreatorQueryResponse
    {
        $handler = new UserCreator($this->userRepository);
        $name = new UserName($query->name());
        $password = new UserPassword($query->password());

        return new UserCreatorQueryResponse($handler->__invoke($name, $password));
    }
}
