<?php

namespace Tests\Unit\User\Domain;

use PHPUnit\Framework\TestCase;
use Shared\Domain\Utils\StringUtils;
use User\Application\Service\Get\UserAuthenticator;
use User\Domain\Services\FindUserByName;
use User\Domain\User;
use User\Domain\ValueObjects\UserId;
use User\Domain\ValueObjects\UserName;
use User\Domain\ValueObjects\UserPassword;
use User\Infrastructure\Persistence\FakeUserRepository;

class FindUserByNameTest extends TestCase
{
    private FindUserByName $findUserByName;

    /** @before */
    public function before(): void
    {
        $repository = new FakeUserRepository();
        $password = new UserPassword("test");

        /** @var UserId $id  */
        $id = UserId::random();

        $repository->save(new User($id, new UserName("test"), $password));

        $this->findUserByName = new FindUserByName($repository);
    }

    /** @test */
    public function user_should_be_found(): void
    {
        $user = ($this->findUserByName)(new UserName("test"));

        self::assertNotEmpty($user);
    }

    /** @test */
    public function user_should_not_be_found(): void
    {
        $user = ($this->findUserByName)(new UserName(StringUtils::random(10)));

        self::assertNull($user);
    }
}