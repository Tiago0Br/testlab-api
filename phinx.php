<?php

require_once __DIR__ . '/bootstrap.php';

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'database' => [
            'adapter' => 'mysql',
            'host' => getenv('DB_HOST'),
            'name' => 'orange-portfolio',
            'user' => getenv('DB_USER'),
            'pass' => getenv('DB_PASS'),
            'port' => getenv('DB_PORT'),
            'charset' => 'utf8',
        ],
    ],
    'version_order' => 'creation',
];
