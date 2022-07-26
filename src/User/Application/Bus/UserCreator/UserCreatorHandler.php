<?php

declare(strict_types=1);

namespace User\Application\Bus\UserCreator;

use Shared\Domain\Bus\CommandHandler;
use Shared\Domain\Bus\QueryHandler;
use User\Application\Bus\UserQuery;
use User\Domain\ValueObjects\UserId;
use User\Domain\ValueObjects\UserName;
use User\Domain\ValueObjects\UserPassword;
use User\Domain\Repositories\UserRepository;
use User\Application\Service\Create\UserCreator;

final class UserCreatorHandler implements CommandHandler {
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    /**
     * @param UserQuery $command
     * @return void
     */
    public function dispatch($command): void
    {
        $handler = new UserCreator($this->userRepository);
        $id = new UserId($command->id());
        $name = new UserName($command->name());
        $password = new UserPassword($command->password());

        $handler->__invoke($id, $name, $password);
    }
}
