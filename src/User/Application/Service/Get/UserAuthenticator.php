<?php
declare(strict_types=1);

namespace User\Application\Service\Get;

use Shared\Domain\ValueObjects\JwtToken;
use User\Domain\Exceptions\PasswordDoesNotMatch;
use User\Domain\User;
use User\Domain\ValueObjects\UserName;
use User\Domain\ValueObjects\UserPassword;
use User\Domain\Exceptions\UserDoesNotExist;
use User\Domain\Repositories\UserRepository;

final class UserAuthenticator
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function __invoke(UserName $username, UserPassword $userPassword): string
    {
        $user = $this->findUser($username);

        $this->authenticate($user, $userPassword);

        return (JwtToken::create(["username" => $username->value()]))->__toString();
    }

    private function authenticate(User $user, UserPassword $userPassword): void
    {
        if (!$user->password()->comparePassword($userPassword))
            throw new PasswordDoesNotMatch($user->name());
    }

    private function findUser(UserName $username): User
    {
        $users = (new FindUserByName($this->userRepository))->__invoke($username);

        if (sizeof($users) === 0) throw new UserDoesNotExist($username);

        return $users[0];
    }
}
