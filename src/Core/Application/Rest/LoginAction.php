<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Core\Application\Rest;

use Exception;
use JsonException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\StatusCode;
use Troupe\TestlabApi\Core\Application\Auth\Authentication;
use Troupe\TestlabApi\Core\Domain\Dto\LoginDto;
use Troupe\TestlabApi\Core\Domain\Service\LoginService;

class LoginAction
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws JsonException
     * @throws Exception
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $loginDto = LoginDto::fromArray((array) $request->getParsedBody());

        /** @var LoginService $loginService */
        $loginService = $this->container->get(LoginService::class);
        $user = $loginService->login($loginDto);

        /** @var Authentication $auth */
        $auth = $this->container->get(Authentication::class);
        $token = $auth->generateToken($user);

        $body = $response->getBody();
        $body->write((string) json_encode(['token' => $token], JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_CREATED)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}