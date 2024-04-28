<?php

declare(strict_types=1);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization');

require_once __DIR__ . '/../bootstrap.php';

try {
    /** @var Slim\App $app */
    $app->run();
} catch (Throwable $e) {
    echo $e->getMessage();
}