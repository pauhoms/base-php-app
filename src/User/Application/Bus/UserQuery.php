<?php

declare(strict_types=1);

namespace User\Application\Bus;

use Shared\Domain\Bus\Command;
use Shared\Domain\Bus\Query;

final class UserQuery implements Query, Command {
    public function __construct(
        private readonly ?string $id,
        private readonly ?string $name,
        private readonly ?string $password
    ) {
    }

    public function id(): ?string
    {
        return $this->id;
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function password(): ?string
    {
        return $this->password;
    }
}
