<?php

namespace User\Application\Service\Get;

use User\Domain\User;
use Shared\Domain\Criteria\Order;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\Filters;
use Shared\Domain\Criteria\OrderBy;
use Shared\Domain\Criteria\Criteria;
use User\Domain\ValueObjects\UserName;
use Shared\Domain\Criteria\FilterField;
use Shared\Domain\Criteria\FilterValue;
use Shared\Domain\Criteria\FilterOperator;
use User\Domain\Repositories\UserRepository;

final class FindUserByName {
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function __invoke(UserName $name): array
    {
        $filterByName = new Filter(new FilterField('name.value'), new FilterOperator('='), new FilterValue($name->value()));

        $criteria = new Criteria(
            new Filters([$filterByName]),
            Order::createAsc(new OrderBy('name.value')),
            null, null
        );

        return $this->userRepository->search($criteria);
    }
}
