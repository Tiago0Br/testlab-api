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
     * @api {post} /users               Cadastro de usuários
     *
     * @apiName CriaUsuario
     * @apiGroup Usuario
     * @apiVersion v1.0.0
     *
     * @apiHeader {String}              Content-Type Tipo de conteúdo enviado: `application/json`.
     *
     * @apiBody {String} name           Nome do usuário
     * @apiBody {String} email          E-mail do usuário
     * @apiBody {String} password       Senha do usuário
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *          "name": "Tiago Lopes",
     *          "email": "teste@gmail.com",
     *          "password": "Senha123"
     *     }
     *
     * @apiSuccess {Int} id             ID do usuário cadastrado
     * @apiSuccess {String} name        Nome do usuário cadastrado
     * @apiSuccess {String} email       E-mail do usuário cadastrado
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 201 Created
     *      {
     *          "id": 1,
     *          "name": "Tiago Lopes",
     *          "email": "teste@gmail.com"
     *      }
     *
     * @apiError {String} type           Tipo de erro, geralmente `BusinessLogic`.
     * @apiError {String} message        Erro ocorrido.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 409 Conflict
     *     {
     *       "type": "BusinessLogic",
     *       "message": "E-mail já cadastrado"
     *     }
     */

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