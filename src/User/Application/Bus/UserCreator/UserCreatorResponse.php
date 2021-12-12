<?php

namespace User\Application\Bus\UserCreator;

use Shared\Domain\Bus\Response;

final class UserCreatorResponse {
    public function __construct(private string $id)
    {
    }

    public function id(): string
    {
        return $this->id;
    }
}
