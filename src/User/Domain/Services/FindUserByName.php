<?php
declare(strict_types=1);

namespace User\Domain\Services;

use Shared\Domain\Criteria\Criteria;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterField;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\Filters;
use Shared\Domain\Criteria\FilterValue;
use Shared\Domain\Criteria\Order;
use Shared\Domain\Criteria\OrderBy;
use User\Domain\Repositories\UserRepository;
use User\Domain\User;
use User\Domain\ValueObjects\UserName;

final class FindUserByName {
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function __invoke(UserName $name): ?User
    {
        $filterByName = new Filter(new FilterField('name.value'), new FilterOperator('='), new FilterValue($name->value()));

        $criteria = new Criteria(
            new Filters([$filterByName]),
            Order::createAsc(new OrderBy('name.value')),
            null, null
        );

        return $this->userRepository->searchOne($criteria);
    }
}
