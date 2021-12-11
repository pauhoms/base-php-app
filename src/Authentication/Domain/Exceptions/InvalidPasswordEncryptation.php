<?php
declare(strict_types=1);

namespace Authentication\Domain\Exceptions;


use RuntimeException;

final class InvalidPasswordEncryptation extends RuntimeException
{
    public function __construct()
    {
        parent::__construct(sprintf("Password encrypt failed"));
    }
}