<?php
declare(strict_types=1);

namespace Authentication\Infrastructure\Persistence\Doctrine\Entity;


use Authentication\Domain\ValueObjects\UserId;
use Shared\Infrastructure\Persistance\Doctrine\UuidType;

final class UserIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return UserId::class;
    }
}