<?php

declare(strict_types=1);

namespace User\Domain\Exceptions;


use RuntimeException;
use User\Domain\ValueObjects\UserName;

final class PasswordDoesNotMatch extends RuntimeException
{
    public function __construct(UserName $userName)
    {
        parent::__construct("The password of user " . $userName->value() . " doesn't match that of the persistence");
    }
}
