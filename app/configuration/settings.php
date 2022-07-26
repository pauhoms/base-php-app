<?php

declare(strict_types=1);

return [
    'mysql' => [
        'cache_dir' => __DIR__ . '/../../var/doctrine',
        'metadata_dirs' => [
            __DIR__ . '/../../src/User/Infrastructure/Persistence/Doctrine/Entity/'
        ],
        'custom-type' => [
            ['user_id', 'User\Infrastructure\Persistence\Doctrine\Entity\UserIdType']
        ],
        'connection' => [
            'driver' => 'pdo_mysql',
            'host' => 'database',
            'port' => 3306,
            'dbname' => 'database',
            'user' => 'root',
            'password' => 'toor'
        ]
    ],
    'rabbit-mq' => [
        "host" => "rabbitmq",
        "port" => 5672,
        "user" => "user",
        "pass" => "pass",
        "exchangeName" => "core"
    ]
];
