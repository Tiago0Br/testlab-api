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
use Troupe\TestlabApi\TestCases\Domain\Dto\UpdateFolderDto;
use Troupe\TestlabApi\TestCases\Domain\Service\UpdateFolder;

class UpdateFolderAction
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws JsonException
     */
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $updateFolderDto = UpdateFolderDto::fromArray(array_merge(
            $args,
            (array) $request->getParsedBody()
        ));

        /** @var UpdateFolder $updateFolder */
        $updateFolder = $this->container->get(UpdateFolder::class);
        $folder = $updateFolder->update($updateFolderDto);

        $body = $response->getBody();
        $body->write((string) json_encode(
            FolderPresenter::format($folder->jsonSerialize()), JSON_THROW_ON_ERROR
        ));

        return $response
            ->withStatus(StatusCode::HTTP_OK)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}