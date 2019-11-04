<?php
require_once dirname(__DIR__) . '/../env.php';
$development = new PDO(getenv('DB_DSN'), getenv('DB_USER'), getenv('DB_PASS'));
$test = new PDO(getenv('DB_DSN') . '_test', getenv('DB_USER'), getenv('DB_PASS'));
return [
    'paths' => [
        'migrations' => __DIR__ . '/migrations',
    ],
    'environments' => [
        'development' => [
            'name' => $development->query('SELECT DATABASE()')->fetchColumn(),
            'connection' => $development
        ],
        'test' => [
            'name' => $test->query('SELECT DATABASE()')->fetchColumn(),
            'connection' => $test
        ]
    ]
];