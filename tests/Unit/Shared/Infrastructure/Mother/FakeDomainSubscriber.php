<?php

namespace Tests\Unit\Shared\Infrastructure\Mother;

use Shared\Domain\Bus\DomainSubscriber;

class FakeDomainSubscriber extends DomainSubscriber
{
    function eventName(): string
    {
        return "fake";
    }

    public function execute(array $body): void
    {
    }

    function origin(): string
    {
        return "fake";
    }
}