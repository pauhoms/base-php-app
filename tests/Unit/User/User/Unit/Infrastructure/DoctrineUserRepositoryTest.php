<?php
declare(strict_types=1);

namespace Tests\Unit\User\User\Unit\Infrastructure;


use User\Domain\User;
use User\Domain\ValueObjects\UserId;
use User\Domain\ValueObjects\UserName;
use User\Domain\ValueObjects\UserPassword;
use User\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use Shared\Domain\Criteria\Criteria;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterField;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\Filters;
use Shared\Domain\Criteria\FilterValue;
use Shared\Domain\Criteria\Order;
use Shared\Domain\Criteria\OrderBy;
use Shared\Domain\ValueObjects\Enum;
use Shared\Domain\ValueObjects\StringValueObject;
use Shared\Infrastructure\Persistance\Doctrine\DoctrineCriteriaConverter;
use Tests\Unit\User\Shared\DoctrineTestCase;


final class DoctrineUserRepositoryTest extends DoctrineTestCase
{
    private DoctrineUserRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = new DoctrineUserRepository($this->getEntityManager());
    }

    /** @test */
    public function userShouldBeSaved(): void
    {
        $user = User::create(new UserName("pau"), new UserPassword("root"));
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
        $filterByName = new Filter(new FilterField('name.value'), new FilterOperator('='), new FilterValue('pau'));
        $filterByPassword = new Filter(new FilterField('password.value'), new FilterOperator('='), new FilterValue('password'));

        $filters = new Filters([$filterByName, $filterByPassword]);
        $order = Order::createDesc(new OrderBy('password.value'));

        $criteria = new Criteria($filters, $order, 3, 2);
        $result = $this->userRepository->search($criteria);

        $this->assertArrayNotHasKey(2, $result);
    }
}