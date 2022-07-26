<?php
declare(strict_types=1);

namespace Tests\Unit\User\Infrastructure;


use Shared\Domain\Criteria\Criteria;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterField;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\Filters;
use Shared\Domain\Criteria\FilterValue;
use Shared\Domain\Criteria\Order;
use Shared\Domain\Criteria\OrderBy;
use Shared\Domain\ValueObjects\Uuid;
use Tests\Unit\Shared\Infrastructure\IntegrationTestCase;
use User\Domain\Repositories\UserRepository;
use User\Domain\User;
use User\Domain\ValueObjects\UserId;
use User\Domain\ValueObjects\UserName;
use User\Domain\ValueObjects\UserPassword;
use User\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;


final class DoctrineUserRepositoryTest extends IntegrationTestCase
{
    private DoctrineUserRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->getContainer()->get(UserRepository::class);
    }

    /** @test */
    public function userShouldBeSaved(): void
    {
        /** @var UserId $id */
        $id = UserId::random();

        $user = User::create($id, new UserName("pau"), new UserPassword("root"));
        $this->userRepository->save($user);

        $this->assertNotNull($this->userRepository->findById($user->id()));
    }

    /** @test */
    public function userShouldBeFound(): void
    {
        $this->assertNotNull($this->userRepository->findById(new UserId('9ae78eef-5842-4f54-814d-be0105d0f6bf')));
    }

    /** @test */
    public function userShouldBeFoundByCriteria(): void
    {
        $filterByName = new Filter(new FilterField('name.value'), new FilterOperator('='), new FilterValue('name'));

        $filters = new Filters([$filterByName]);
        $order = Order::createDesc(new OrderBy('password.value'));

        $criteria = new Criteria($filters, $order, null, null);
        $result = $this->userRepository->searchOne($criteria);

        $this->assertNotNull($result);
    }
}
