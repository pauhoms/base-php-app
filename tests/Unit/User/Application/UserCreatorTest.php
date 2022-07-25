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
use User\Application\Bus\UserCreator\UserCreatorQueryResponse;

final class UserCreatorTest extends TestCase
{
    private UserCreator $userCreator;
    private FakeUserRepository $fakeUserRepository;

    /** @before */
    public function before(): void
    {
        $this->fakeUserRepository = new FakeUserRepository();
        $password = new UserPassword("test");
        $password->encryptPassword();

        /** @var UserId $id  */
        $id = UserId::random();

        $this->fakeUserRepository->save(new User($id, new UserName("test"), $password));
        
        $this->userCreator = new UserCreator($this->fakeUserRepository);
    }

    /** @test */
    public function user_should_be_created(): void
    {
        $userId = UserId::random();
        $this->userCreator->__invoke($userId, new UserName("test2"), new UserPassword("test"));

        self::assertNotNull($this->fakeUserRepository->findById($userId));
    }

    /** @test */
    public function user_should_not_be_created(): void
    {
        $this->expectException(UserDoesExist::class);
        $this->userCreator->__invoke(UserId::random(), new UserName("test"), new UserPassword("test"));
    }
}
