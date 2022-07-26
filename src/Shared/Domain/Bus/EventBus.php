<?php

namespace Shared\Domain\Bus;

interface EventBus
{
    /** @param DomainEvent[] $domainEvents */
    public function publish(array $domainEvents): void;

    /** @param DomainSubscriber[] $subscribers */
    public function subscribe(array $subscribers): void;
}
