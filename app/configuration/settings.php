<?php

return [
    'mysql' => [
        'cache_dir' => __DIR__ . '/../../var/doctrine',
        'metadata_dirs' => [
            __DIR__ . '/../../src/Authentication/Infrastructure/Persistence/Doctrine/Entity/'
        ],
        'custom-type' => [
            ['user_id', 'Authentication\Infrastructure\Persistence\Doctrine\Entity\UserIdType']
        ],
        'connection' => [
            'driver' => 'pdo_mysql',
            'host' => '127.0.0.1',
            'port' => 3306,
            'dbname' => 'auth_database',
            'user' => 'root',
            'password' => 'toor'
        ]
    ]
];
