<?php
namespace Model;
return [
    'service_manager' => [
        'services' => [
            'model-primary-adapter-config' => [
                'driver' => 'PDO',
                'dsn' => 'mysql:hostname=localhost;dbname=onlinemarket',
                'username' => 'vagrant',
                'password' => 'vagrant',
            ],
        ],
        'factories' => [
            'model-primary-adapter' => Adapter\Factory\PrimaryFactory::class,
            'model-listings-table' => Table\Factory\ListingsTableFactory::class,
        ],
    ],
];
