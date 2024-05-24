<?php

declare(strict_types=1);

use Slim\App;
use Troupe\TestlabApi\Core\Application\Rest\CreateUserAction;
use Troupe\TestlabApi\Core\Application\Rest\GetUserByIdAction;
use Troupe\TestlabApi\Core\Application\Rest\LoginAction;

/** @var App $app */
$container = $app->getContainer();

$app->group('/users', function (App $app) use ($container) {
    $app->post('', new CreateUserAction($container));
    $app->get('/{id}', new GetUserByIdAction($container));
});

$app->post('/login', new LoginAction($container));