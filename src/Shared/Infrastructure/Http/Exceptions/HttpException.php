<?php

namespace Shared\Infrastructure\Http\Exceptions;

use RuntimeException;

class HttpException extends RuntimeException
{
    public function __construct(string $message, public int $httpCode)
    {
        parent::__construct($message);
    }
}
