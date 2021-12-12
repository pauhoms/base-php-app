<?php

namespace Shared\Domain\Exceptions;

use RuntimeException;

final class InvalidToken extends RuntimeException
{
    public function __construct(string $token)
    {
        parent::__construct("The token $token is incorrect");
    }
}
