<?php

namespace Shared\Infrastructure\Rabbitmq;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Shared\Domain\Bus\DomainEvent;
use Shared\Domain\Bus\DomainSubscriber;
use Shared\Domain\Bus\EventBus;

final class RabbitMqEventBus implements EventBus
{
    private readonly AMQPChannel $channel;
    private readonly AMQPStreamConnection $connection;
    private readonly string $exchangeName;

    public function __construct(string $host, int $port, string $user, string $password, string $exchangeName)
    {
        $this->connection = new AMQPStreamConnection($host, $port, $user, $password);
        $this->channel = $this->connection->channel();

        $this->exchangeName = $exchangeName;
        $this->channel->exchange_declare($this->exchangeName, 'fanout', false, true);
    }

    public function start(): void
    {
        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    /** @param DomainEvent[] $domainEvents */
    public function publish(array $domainEvents): void
    {
        array_walk(
            $domainEvents,
            fn (DomainEvent $domainEvent) => $this->channel->basic_publish(
                new AMQPMessage(json_encode($domainEvent->toPrimitive())),
                $this->exchangeName,
                $domainEvent->eventName()
            )
        );
    }

    /** @param DomainSubscriber[] $subscribers */
    public function subscribe(array $subscribers): void
    {
        array_walk($subscribers, [$this, 'createDomainSubscribe']);
    }

    public function close(): void
    {
        $this->channel->close();
        $this->connection->close();
    }

    public function isOnline(): bool
    {
        return $this->connection->isConnected();
    }

    private function createDomainSubscribe(DomainSubscriber $domainSubscriber): void
    {
        $this->channel->exchange_declare($domainSubscriber->origin(), 'fanout', false, true);
        $this->channel->queue_declare($domainSubscriber->eventName(), false, true);
        $this->channel->queue_bind(
            $domainSubscriber->eventName(), $domainSubscriber->origin(), $domainSubscriber->eventName()
        );

        $this->channel->basic_consume(
            $domainSubscriber->eventName(),
            '',
            false,
            true,
            false,
            false,
            function (AMQPMessage $message) use ($domainSubscriber) {
                $domainSubscriber->execute(json_decode($message->getBody(), true));
            }
        );
    }
}