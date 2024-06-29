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
     * @api {post} /login               Realiza login no sistema
     *
     * @apiName Login
     * @apiGroup Usuario
     * @apiVersion v1.0.0
     *
     * @apiHeader {String}              Content-Type Tipo de conteúdo enviado: `application/json`.
     *
     * @apiBody {String} email          E-mail do usuário
     * @apiBody {String} password       Senha do usuário
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *          "email": "teste@gmail.com",
     *          "password": "Senha123"
     *     }
     *
     * @apiSuccess {Object} user            Dados do usuário que fez o login
     * @apiSuccess {Int} user.id            ID do usuário logado
     * @apiSuccess {String} user.name       Nome do usuário logado
     * @apiSuccess {String} user.email      E-mail do usuário logado
     * @apiSuccess {String} token           Token de autenticação do usuário
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 201 Created
     *      {
     *          "user": {
     *              "id": 1,
     *              "name": "Tiago Lopes",
     *              "email": "teste2@gmail.com"
     *          },
     *          "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.asdasd35345345"
     *      }
     *
     * @apiError {String} type           Tipo de erro, geralmente `BusinessLogic`.
     * @apiError {String} message        Erro ocorrido.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 409 Conflict
     *     {
     *       "type": "BusinessLogic",
     *       "message": "E-mail e/ou senha inválidos"
     *     }
     */

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
        $responseBody = array_merge(
            ['user' => $user->jsonSerialize()],
            ['token' => $token]
        );
        $body->write((string) json_encode($responseBody, JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_CREATED)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}