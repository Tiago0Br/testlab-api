<?php

declare(strict_types=1);

use Slim\App;
use Troupe\TestlabApi\Core\Application\Middlewares\CheckToken;
use Troupe\TestlabApi\Core\Application\Rest\CreateUserAction;
use Troupe\TestlabApi\Core\Application\Rest\GetUserByIdAction;
use Troupe\TestlabApi\Core\Application\Rest\GetUserProjectsAction;
use Troupe\TestlabApi\Core\Application\Rest\LoginAction;
use Troupe\TestlabApi\Core\Application\Rest\RecoverUserInfo;

/** @var App $app */
$container = $app->getContainer();

$app->group('/users', function (App $app) use ($container) {
    $app->post('/new', new CreateUserAction($container));
    $app->get('/info', new RecoverUserInfo($container))
        ->add(new CheckToken($container));
    $app->get('/projects', new GetUserProjectsAction($container))
        ->add(new CheckToken($container));
    $app->get('/{id}', new GetUserByIdAction($container))
        ->add(new CheckToken($container));
});

$app->post('/login', new LoginAction($container));