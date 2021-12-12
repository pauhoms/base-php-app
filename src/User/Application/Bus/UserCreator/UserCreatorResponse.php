<?php

namespace User\Application\Bus\UserCreator;

final class UserCreatorResponse {
    public function __construct(private string $id)
    {
    }

    public function id(): string
    {
        return $this->id;
    }
}
