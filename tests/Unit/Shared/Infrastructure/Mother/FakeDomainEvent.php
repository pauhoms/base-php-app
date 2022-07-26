<?php

namespace Tests\Unit\Shared\Infrastructure\Mother;

use Shared\Domain\Bus\DomainEvent;
use Shared\Domain\ValueObjects\EventId;
use Shared\Domain\ValueObjects\Uuid;

class FakeDomainEvent extends DomainEvent
{
    public function __construct()
    {
        /** @var EventId $id */
        $id = EventId::random();
        parent::__construct($id);
    }

    function eventName(): string
    {
        return "fake";
    }

    function toPrimitive(): array
    {
        return [
            "aggregateId" => $this->aggregateId,
            "eventId" => $this->eventId,
            "occurredOn" => $this->occurredOn,
            "date" => ["test" => 1]
        ];
    }
}