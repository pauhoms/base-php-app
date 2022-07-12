<?php

declare(strict_types=1);

namespace User\Application\Bus;

final class UserQuery {
    public function __construct(
        private readonly ?string $id,
        private readonly string $name,
        private readonly string $password
    ) {
    }

    public function id(): ?string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function password(): string
    {
        return $this->password;
    }
}
