<?php

declare(strict_types=1);

namespace User\Application\Bus\UserCreator;

use Shared\Domain\Bus\QueryResponse;

final class UserCreatorQueryResponse implements QueryResponse {
    public function __construct(private readonly string $id)
    {
    }

    public function id(): string
    {
        return $this->id;
    }
}
