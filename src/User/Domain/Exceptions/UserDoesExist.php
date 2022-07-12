<?php
declare(strict_types=1);

namespace User\Domain\Exceptions;


use RuntimeException;
use User\Domain\ValueObjects\UserName;

final class UserDoesExist extends RuntimeException
{
    public function __construct(UserName $userName)
    {
        parent::__construct("The user " . $userName->value() . " exist");
    }
}
