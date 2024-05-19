<?php

declare(strict_types=1);

use Slim\App;
use Troupe\TestlabApi\TestCases\Application\Rest\CreateFolderAction;
use Troupe\TestlabApi\TestCases\Application\Rest\CreateProjectAction;
use Troupe\TestlabApi\TestCases\Application\Rest\CreateTestCaseAction;
use Troupe\TestlabApi\TestCases\Application\Rest\DeleteFolderAction;
use Troupe\TestlabApi\TestCases\Application\Rest\DeleteProjectAction;
use Troupe\TestlabApi\TestCases\Application\Rest\GetProjectAction;
use Troupe\TestlabApi\TestCases\Application\Rest\UpdateFolderAction;
use Troupe\TestlabApi\TestCases\Application\Rest\UpdateProjectAction;

/** @var App $app */
$container = $app->getContainer();

$app->group('/projects', function (App $app) use ($container) {
    $app->post('', new CreateProjectAction($container));
    $app->put('/{id}', new UpdateProjectAction($container));
    $app->get('/{id}', new GetProjectAction($container));
    $app->delete('/{id}', new DeleteProjectAction($container));

    $app->group('/{project_id}/folders', function (App $app) use ($container) {
        $app->post('', new CreateFolderAction($container));
        $app->put('/{id}', new UpdateFolderAction($container));
        $app->delete('/{id}', new DeleteFolderAction($container));

        $app->group('/{test_suite_id}/test_cases', function (App $app) use ($container) {
            $app->post('', new CreateTestCaseAction($container));
        });
    });
});