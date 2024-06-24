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
     * @api {get} /users/{id}           Busca usuário por ID
     *
     * @apiExample Exemplo:
     *      http://localhost:8080/users/1234
     *
     * @apiName BuscaUsuarioPorId
     * @apiGroup Usuario
     * @apiVersion v1.0.0
     *
     * @apiHeader {String}              Content-Type Tipo de conteúdo enviado: `application/json`.
     *
     * @apiParam {String} id            ID do usuário
     *
     * @apiSuccess {Object} message     Mensagem de retorno da API.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
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
     *     HTTP/1.1 404 Not Found
     *     {
     *       "type": "NotFound",
     *       "message": "Usuário não encontrado"
     *     }
     */

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