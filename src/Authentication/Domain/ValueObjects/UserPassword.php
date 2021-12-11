<?php
declare(strict_types=1);

namespace Authentication\Domain\ValueObjects;


use Authentication\Domain\Exceptions\InvalidPasswordEncryptation;
use Shared\Domain\ValueObjects\StringValueObject;

final class UserPassword extends StringValueObject
{
    private array $encryptOptions = [
        'cost' => 12,
    ];

    public function encryptPassword(): void
    {
        if ($this->isEmpty())
            throw new InvalidPasswordEncryptation();

        $this->value = password_hash($this->value(), PASSWORD_BCRYPT, $this->encryptOptions);
    }

    public function comparePassword(UserPassword $password): bool
    {
        return password_verify($password->value(), $this->value());
    }
}
