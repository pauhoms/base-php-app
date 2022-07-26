<?php

declare(strict_types=1);

use Shared\Infrastructure\Rabbitmq\RabbitMqEventBus;

$settings = (require __DIR__ . '/settings.php')["rabbit-mq"];

$eventBus = new RabbitMqEventBus(
    $settings["host"],
    $settings["port"],
    $settings["user"],
    $settings["pass"],
    $settings["exchangeName"]
);

return $eventBus;