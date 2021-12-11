<?php
declare(strict_types=1);

namespace Authentication\Domain\ValueObjects;


use Shared\Domain\ValueObjects\Collection;
use Shared\Domain\ValueObjects\StringValueObject;

final class UserRoles extends Collection
{
    protected function type(): string
    {
        return StringValueObject::class;
    }
}
