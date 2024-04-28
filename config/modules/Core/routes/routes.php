<?php

declare(strict_types=1);

use Slim\App;
use Troupe\TestlabApi\Core\Application\Rest\CreateUserAction;

/** @var App $app */
$container = $app->getContainer();

$app->group('/users', function (App $app) use ($container) {
    $app->post('', new CreateUserAction($container));
});