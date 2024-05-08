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
use Troupe\TestlabApi\Core\Domain\Dto\CreateUserDto;
use Troupe\TestlabApi\Core\Domain\Service\CreateUser;

class CreateUserAction
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
        $createUserDto = CreateUserDto::fromArray(
            (array) $request->getParsedBody()
        );

        /** @var CreateUser $createUser */
        $createUser = $this->container->get(CreateUser::class);
        $user = $createUser->create($createUserDto);

        $body = $response->getBody();

        $body->write((string) json_encode($user->jsonSerialize(), JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_CREATED)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}