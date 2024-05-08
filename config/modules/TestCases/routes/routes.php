<?php

declare(strict_types=1);

use Slim\App;
use Troupe\TestlabApi\TestCases\Application\Rest\CreateProjectAction;

/** @var App $app */
$container = $app->getContainer();

$app->group('/projects', function (App $app) use ($container) {
    $app->post('', new CreateProjectAction($container));
});