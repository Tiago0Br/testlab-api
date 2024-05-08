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
use Troupe\TestlabApi\Core\Domain\Dto\GetUserByIdDto;
use Troupe\TestlabApi\Core\Domain\Repository\UserRepositoryInterface;

class GetUserByIdAction
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @throws JsonException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $getUserByIdDto = GetUserByIdDto::fromArray($args);

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = $this->container->get(UserRepositoryInterface::class);
        $user = $userRepository->getById($getUserByIdDto->id);

        $body = $response->getBody();
        $body->write((string) json_encode($user->jsonSerialize(), JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_OK)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}