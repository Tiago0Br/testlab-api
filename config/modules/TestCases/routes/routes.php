<?php

declare(strict_types=1);

use Slim\App;
use Troupe\TestlabApi\Core\Application\Middlewares\CheckToken;
use Troupe\TestlabApi\TestCases\Application\Rest\ChangeTestCaseStatusAction;
use Troupe\TestlabApi\TestCases\Application\Rest\CreateFolderAction;
use Troupe\TestlabApi\TestCases\Application\Rest\CreateProjectAction;
use Troupe\TestlabApi\TestCases\Application\Rest\CreateTestCaseAction;
use Troupe\TestlabApi\TestCases\Application\Rest\DeleteFolderAction;
use Troupe\TestlabApi\TestCases\Application\Rest\DeleteProjectAction;
use Troupe\TestlabApi\TestCases\Application\Rest\DeleteTestCaseAction;
use Troupe\TestlabApi\TestCases\Application\Rest\GetFolder;
use Troupe\TestlabApi\TestCases\Application\Rest\GetProjectAction;
use Troupe\TestlabApi\TestCases\Application\Rest\GetFolderContentAction;
use Troupe\TestlabApi\TestCases\Application\Rest\GetProjectContentAction;
use Troupe\TestlabApi\TestCases\Application\Rest\GetTestCaseAction;
use Troupe\TestlabApi\TestCases\Application\Rest\ListTestCaseStatusAction;
use Troupe\TestlabApi\TestCases\Application\Rest\UpdateFolderAction;
use Troupe\TestlabApi\TestCases\Application\Rest\UpdateProjectAction;
use Troupe\TestlabApi\TestCases\Application\Rest\UpdateTestCaseAction;

/** @var App $app */
$container = $app->getContainer();

$app->group('/projects', function (App $app) use ($container) {
    $app->post('/new', new CreateProjectAction($container));
    $app->put('/{id}', new UpdateProjectAction($container));
    $app->get('/{id}', new GetProjectAction($container));
    $app->delete('/{id}', new DeleteProjectAction($container));
    $app->get('/{id}/content', new GetProjectContentAction($container));
})
    ->add(new CheckToken($container));

$app->group('/folders', function (App $app) use ($container) {
    $app->post('/new', new CreateFolderAction($container));
    $app->put('/{id}', new UpdateFolderAction($container));
    $app->delete('/{id}', new DeleteFolderAction($container));
    $app->get('/{id}', new GetFolder($container));
    $app->get('/{id}/content', new GetFolderContentAction($container));
})
    ->add(new CheckToken($container));

$app->group('/test_cases', function (App $app) use ($container) {
    $app->post('/new', new CreateTestCaseAction($container));
    $app->get('/status', new ListTestCaseStatusAction());
    $app->get('/{id}', new GetTestCaseAction($container));
    $app->put('/{id}', new UpdateTestCaseAction($container));
    $app->delete('/{id}', new DeleteTestCaseAction($container));

    $app->put('/{id}/status', new ChangeTestCaseStatusAction($container));
})
    ->add(new CheckToken($container));