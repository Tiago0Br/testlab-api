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
use Troupe\TestlabApi\TestCases\Domain\Dto\DeleteFolderDto;
use Troupe\TestlabApi\TestCases\Domain\Service\DeleteFolder;

class DeleteFolderAction
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
        $deleteFolderDto = DeleteFolderDto::fromArray($args);

        /** @var DeleteFolder $deleteFolder */
        $deleteFolder = $this->container->get(DeleteFolder::class);
        $folderArray = $deleteFolder->remove($deleteFolderDto);

        $body = $response->getBody();
        $responseBody = [
            'id' => $folderArray['id'],
        ];
        $body->write((string) json_encode($responseBody, JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_OK)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}