<?php

return [
    'default' => getenv('DB_CONNECTION', 'mysql'),
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => getenv('DB_HOST', 'localhost'),
            'port' => getenv('DB_PORT', '3306'),
            'database' => getenv('DB_DATABASE', 'database'),
            'username' => getenv('DB_USERNAME', 'root'),
            'password' => getenv('DB_PASSWORD', ''),
            'charset' => getenv('DB_CHARSET', 'utf8mb4'),
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ],
        ],
    ]
];


//return [
//    'default' => $_ENV['DB_CONNECTION'] ?? 'mysql',
//    'connections' => [
//        'mysql' => [
//            'driver' => 'mysql',
//            'host' => $_ENV['DB_HOST'] ?? 'localhost',
//            'port' => $_ENV['DB_PORT'] ?? '3306',
//            'database' => $_ENV['DB_DATABASE'] ?? 'database',
//            'username' => $_ENV['DB_USERNAME'] ?? 'root',
//            'password' => $_ENV['DB_PASSWORD'] ?? '',
//            'charset' => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
//            'options' => [
//                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//                    PDO::ATTR_EMULATE_PREPARES => false,
//                ] ?? [],
//        ],
//    ]
//];