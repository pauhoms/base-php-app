<?php

namespace Shared\Infrastructure\Persistance;

abstract class BaseFakeRepository
{
    protected array $value;

    public function __construct(array $value = [])
    {
        $this->value = $value;
    }

    protected function add(object $obj): void
    {
        array_push($this->value, $obj);
    }

    protected function get(): array
    {
        return $this->value;
    }
}
