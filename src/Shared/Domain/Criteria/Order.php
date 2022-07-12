<?php
declare(strict_types=1);

namespace Shared\Domain\Criteria;


final class Order
{
    public function __construct(private readonly OrderBy $orderBy, private readonly OrderType $orderType)
    {
    }

    public static function createDesc(OrderBy $orderBy): Order
    {
        return new self($orderBy, OrderType::DESC);
    }

    public static function createAsc(OrderBy $orderBy): Order
    {
        return new self($orderBy, OrderType::ASC);
    }

    public static function none(): Order
    {
        return new Order(new OrderBy(''), OrderType::NONE);
    }

    public function orderBy(): OrderBy
    {
        return $this->orderBy;
    }

    public function orderType(): OrderType
    {
        return $this->orderType;
    }

    public function isNone(): bool
    {
        return $this->orderType() === OrderType::NONE;
    }

    public function serialize(): string
    {
        return sprintf('%s.%s', $this->orderBy->value(), $this->orderType->value);
    }
}
