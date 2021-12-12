<?php


namespace User\Domain;


use User\Domain\ValueObjects\UserId;
use User\Domain\ValueObjects\UserName;
use User\Domain\ValueObjects\UserPassword;

final class User
{
    public function __construct(
        private UserId $id,
        private UserName $name,
        private UserPassword $password
    ) {
    }

    public function name(): UserName
    {
        return $this->name;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function password(): UserPassword
    {
        return $this->password;
    }

    public static function create(UserName $name, UserPassword $password): self
    {
        $password->encryptPassword();
        return new User(UserId::random(), $name, $password);
    }
}
