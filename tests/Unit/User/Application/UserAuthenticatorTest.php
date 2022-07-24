<?php

namespace Tests\Unit\User\Application;

use PHPUnit\Framework\TestCase;
use User\Application\Service\Get\UserAuthenticator;
use User\Domain\Exceptions\UserDoesNotExist;
use User\Domain\User;
use User\Domain\ValueObjects\UserId;
use User\Domain\ValueObjects\UserName;
use User\Domain\ValueObjects\UserPassword;
use User\Infrastructure\Persistence\FakeUserRepository;

final class UserAuthenticatorTest extends TestCase
{
    private UserAuthenticator $userAuthenticator;

    /** @before */
    public function before(): void
    {
        $repository = new FakeUserRepository();
        $password = new UserPassword("test");
        $password->encryptPassword();

        /** @var UserId $id  */
        $id = UserId::random();

        $repository->save(new User($id, new UserName("test"), $password));

        $this->userAuthenticator = new UserAuthenticator($repository);
    }

    /** @test */
    public function userShouldBeAuthenticated(): void
    {
        $this->assertNotNull(
            $this->userAuthenticator->__invoke(new UserName("test"), new UserPassword("test"))
        );
    }

    /** @test */
    public function userShouldNotExist(): void
    {
        $this->expectException(UserDoesNotExist::class);
        $this->userAuthenticator->__invoke(new UserName("cvfcg"), new UserPassword("test"));
    }
}
