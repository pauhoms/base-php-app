<?php
namespace Tests\Unit\User\Application;

use User\Domain\User;
use PHPUnit\Framework\TestCase;
use User\Domain\ValueObjects\UserId;
use User\Domain\ValueObjects\UserName;
use User\Domain\Exceptions\UserDoesExist;
use User\Domain\ValueObjects\UserPassword;
use User\Domain\Repositories\UserRepository;
use User\Application\Service\Create\UserCreator;
use User\Infrastructure\Persistence\FakeUserRepository;
use User\Application\Bus\UserCreator\UserCreatorResponse;

final class UserCreatorTest extends TestCase
{
    private UserCreator $userCreator;

    /** @before */
    public function before(): void
    {
        $repository = new FakeUserRepository();
        $password = new UserPassword("test");
        $password->encryptPassword();

        $repository->save(new User(UserId::random(), new UserName("test"), $password));
        
        $this->userCreator = new UserCreator($repository);
    }

    /** @test */
    public function userShouldBeCreated(): void
    {
        $this->assertNotNull(
            $this->userCreator->__invoke(new UserName("test2"), new UserPassword("test"))
        );
    }

    /** @test */
    public function userShouldBeExist(): void
    {
        $this->expectException(UserDoesExist::class);
        $this->userCreator->__invoke(new UserName("test"), new UserPassword("test"));
    }
}
