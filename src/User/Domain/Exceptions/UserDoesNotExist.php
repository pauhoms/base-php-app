<?php
declare(strict_types=1);

namespace User\Domain\Exceptions;


use RuntimeException;
use User\Domain\ValueObjects\UserName;

final class UserDoesNotExist extends RuntimeException
{
    public function __construct(UserName $userName)
    {
        parent::__construct("The user " . $userName->value() . " doesn't exist");
    }
}
