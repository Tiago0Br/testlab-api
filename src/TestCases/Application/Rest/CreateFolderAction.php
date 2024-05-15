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
use Troupe\TestlabApi\TestCases\Domain\Dto\CreateFolderDto;
use Troupe\TestlabApi\TestCases\Domain\Service\CreateFolder;

class CreateFolderAction
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @throws JsonException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $createFolderDto = CreateFolderDto::fromArray(array_merge(
            $args,
            (array) $request->getParsedBody()
        ));

        /** @var CreateFolder $createFolder */
        $createFolder = $this->container->get(CreateFolder::class);
        $folder = $createFolder->create($createFolderDto);

        $body = $response->getBody();
        $body->write((string) json_encode($folder->jsonSerialize(), JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_CREATED)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}