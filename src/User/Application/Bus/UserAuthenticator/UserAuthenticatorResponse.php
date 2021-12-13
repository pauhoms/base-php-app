<?php

namespace User\Application\Bus\UserAuthenticator;

final class UserAuthenticatorResponse
{
    public function __construct(private string $token)
    {
    }

    public function token(): string
    {
        return $this->token;
    }
}
