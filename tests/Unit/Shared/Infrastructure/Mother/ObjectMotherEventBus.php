<?php

namespace Tests\Unit\Shared\Infrastructure\Mother;

class ObjectMotherEventBus
{
    static function validEventSubscriber(): FakeDomainSubscriber
    {
        return new FakeDomainSubscriber();
    }
}