<?php
declare(strict_types=1);

namespace Shared\Domain\ValueObjects;


use ArrayIterator;
use Countable;
use IteratorAggregate;
use Shared\Domain\Assert;

abstract class Collection implements Countable, IteratorAggregate
{
    private array $items;

    public function __construct(array $items)
    {
        $this->items = $items;
        Assert::arrayOf($this->type(), $items);
    }

    abstract protected function type(): string;

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items());
    }

    public function count(): int
    {
        return count($this->items());
    }

    protected function items(): array
    {
        return $this->items;
    }
}
