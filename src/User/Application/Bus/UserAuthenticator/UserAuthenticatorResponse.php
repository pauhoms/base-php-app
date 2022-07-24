<?php

declare(strict_types=1);

namespace User\Application\Bus\UserAuthenticator;

use Shared\Domain\Bus\QueryResponse;

final class UserAuthenticatorResponse implements QueryResponse
{
    public function __construct(private readonly string $token)
    {
    }

    public function token(): string
    {
        return $this->token;
    }
}
