<?php

namespace Shared\Domain\Bus;

use Shared\Domain\ValueObjects\Date;
use Shared\Domain\ValueObjects\EventId;
use Shared\Domain\ValueObjects\Uuid;

abstract class DomainEvent
{
    readonly EventId $eventId;
    readonly Uuid $aggregateId;
    readonly Date $occurredOn;

    public function __construct(Uuid $aggregateId)
    {
        /** @var EventId eventId */
        $eventId = EventId::random();
        $this->eventId = $eventId;

        $this->occurredOn = Date::current();
        $this->aggregateId = $aggregateId;
    }

    abstract function eventName(): string;
    abstract function toPrimitive(): array;
}
