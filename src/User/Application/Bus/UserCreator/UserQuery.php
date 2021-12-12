<?php

namespace User\Application\Bus\UserCreator;

final class UserQuery {
    public function __construct(private ?string $id, private string $name, private string $password)
    {
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
