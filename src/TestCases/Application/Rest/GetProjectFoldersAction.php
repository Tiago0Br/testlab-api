<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Application\Rest;

use JsonException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\StatusCode;
use Troupe\TestlabApi\TestCases\Application\Presenter\FolderPresenter;
use Troupe\TestlabApi\TestCases\Domain\Dto\GetProjectDto;
use Troupe\TestlabApi\TestCases\Domain\Entity\Folder;
use Troupe\TestlabApi\TestCases\Domain\Repository\FolderRepositoryInterface;

class GetProjectFoldersAction
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
        $getProjectDto = GetProjectDto::fromArray($args);

        /** @var FolderRepositoryInterface $folderRepository */
        $folderRepository = $this->container->get(FolderRepositoryInterface::class);
        $folders = $folderRepository->getProjectFolders($getProjectDto->id);

        $responseBody = array_map(fn(Folder $folder) => FolderPresenter::format($folder->jsonSerialize()), $folders);

        $body = $response->getBody();
        $body->write((string) json_encode($responseBody, JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_OK)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}