<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Core\Application\Rest;

use JsonException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\StatusCode;
use Troupe\TestlabApi\TestCases\Domain\Entity\Project;
use Troupe\TestlabApi\TestCases\Domain\Repository\ProjectRepositoryInterface;

class GetUserProjectsAction
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws JsonException
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $userId = (int) $request->getQueryParams()['user_id'];

        /** @var ProjectRepositoryInterface $projectRepository */
        $projectRepository = $this->container->get(ProjectRepositoryInterface::class);
        $projects = $projectRepository->getUserProjects($userId);

        $responseBody = array_map(function(Project $project) {
            $projectArray = $project->jsonSerialize();
            unset($projectArray['owner_user']);
            return $projectArray;
        }, $projects);

        $body = $response->getBody();
        $body->write((string) json_encode($responseBody, JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_OK)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}