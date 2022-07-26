<?php

namespace Tests\Unit\Shared\Infrastructure;

use Shared\Domain\Bus\EventBus;
use Shared\Infrastructure\Rabbitmq\RabbitMqEventBus;
use Tests\Unit\Shared\Infrastructure\Mother\ObjectMotherEventBus;

class RabbitMqEventBusTest extends IntegrationTestCase
{
    private RabbitMqEventBus $eventBus;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventBus = $this->getContainer()->get(EventBus::class);
    }

    /** @test */
    public function event_bus_should_be_connected(): void
    {
        self::assertTrue($this->eventBus->isOnline());
    }

    /** @test */
    public function domain_subscriber_should_subscribe_to_queue(): void
    {
        $this->eventBus->subscribe([ObjectMotherEventBus::validEventSubscriber()]);

        self::assertTrue(true);
    }
}