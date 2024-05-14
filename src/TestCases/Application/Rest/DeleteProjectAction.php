<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Application\Rest;

use JsonException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\StatusCode;
use Troupe\TestlabApi\TestCases\Domain\Dto\GetProjectDto;
use Troupe\TestlabApi\TestCases\Domain\Service\DeleteProject;

class DeleteProjectAction
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws JsonException
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $projectDto = GetProjectDto::fromArray($args);

        /** @var DeleteProject $deleteProject */
        $deleteProject = $this->container->get(DeleteProject::class);
        $removedProject = $deleteProject->remove($projectDto->id);

        $body = $response->getBody();
        $body->write((string) json_encode($removedProject, JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_OK)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}