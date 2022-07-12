<?php

declare(strict_types=1);

namespace User\Application\Bus\UserAuthenticator;

final class UserAuthenticatorResponse
{
    public function __construct(private readonly string $token)
    {
    }

    public function token(): string
    {
        return $this->token;
    }
}
