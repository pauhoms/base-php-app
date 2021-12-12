<?php
declare(strict_types=1);

namespace User\Infrastructure\Persistence\Doctrine\Entity;


use User\Domain\ValueObjects\UserId;
use Shared\Infrastructure\Persistance\Doctrine\UuidType;

final class UserIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return UserId::class;
    }
}