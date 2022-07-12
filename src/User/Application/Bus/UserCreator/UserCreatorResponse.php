<?php

declare(strict_types=1);

namespace User\Application\Bus\UserCreator;

final class UserCreatorResponse {
    public function __construct(private readonly string $id)
    {
    }

    public function id(): string
    {
        return $this->id;
    }
}
