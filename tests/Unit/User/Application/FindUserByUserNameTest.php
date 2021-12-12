<?php
namespace Tests\Unit\User\Application;

use PHPUnit\Framework\TestCase;
use User\Application\Bus\UserCreator\UserCreatorResponse;
use User\Application\Service\Create\UserCreator;
use User\Domain\Exceptions\UserDoesExist;
use User\Domain\Repositories\UserRepository;
use User\Domain\ValueObjects\UserName;
use User\Domain\ValueObjects\UserPassword;
use User\Infrastructure\Persistence\FakeUserRepository;

final class FindUserByUserNameTest extends TestCase
{
    private UserCreator $userCreator;

    /** @before */
    public function before(): void
    {
        $this->userCreator = new UserCreator(new FakeUserRepository());
    }

    /** @test */
    public function userShouldBeCreated(): void
    {
        $this->assertNotNull(
            $this->userCreator->__invoke(new UserName("test"), new UserPassword("test"))
        );
    }

    /** @test */
    public function userShouldBeExist(): void
    {
        $this->userCreator->__invoke(new UserName("test"), new UserPassword("test"));
        $this->expectException(UserDoesExist::class);
        $this->userCreator->__invoke(new UserName("test"), new UserPassword("test"));
    }
}
