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
use Troupe\TestlabApi\Core\Domain\Repository\UserRepositoryInterface;

class RecoverUserInfo
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @api {get} /users                Recupera informações do usuário logado
     *
     * @apiName RecuperaInformacoesUsuario
     * @apiGroup Usuario
     * @apiVersion v1.0.0
     *
     * @apiHeader {String}              Content-Type Tipo de conteúdo enviado: `application/json`.
     *
     * @apiSuccess {Int} id             ID do usuário cadastrado
     * @apiSuccess {String} name        Nome do usuário cadastrado
     * @apiSuccess {String} email       E-mail do usuário cadastrado
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
     *     HTTP/1.1 401 Unauthorized
     *     {
     *       "type": "Unauthorized",
     *       "message": "Token inválido ou não informado"
     *     }
     */

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws JsonException
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $userId = (int) $request->getQueryParams()['user_id'];

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = $this->container->get(UserRepositoryInterface::class);
        $user = $userRepository->getById($userId);

        $body = $response->getBody();
        $body->write((string) json_encode($user->jsonSerialize(), JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_OK)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}