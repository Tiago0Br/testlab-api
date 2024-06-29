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
use Troupe\TestlabApi\TestCases\Domain\Entity\Project;
use Troupe\TestlabApi\TestCases\Domain\Repository\ProjectRepositoryInterface;

class GetUserProjectsAction
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @api {get} /users/projects       Busca os projetos que o usuário tem acesso
     *
     * @apiName BuscaProjetosDoUsuario
     * @apiGroup Usuario
     * @apiVersion v1.0.0
     *
     * @apiHeader {String}              Content-Type Tipo de conteúdo enviado: `application/json`.
     *
     * @apiSuccess {Object[]} data              Array com os projetos que o usuário tem acesso
     * @apiSuccess {Int} data.id                ID do projeto
     * @apiSuccess {String} data.name           Nome do projeto
     * @apiSuccess {String} data.description    Descrição do projeto
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *      [
     *          {
     *              "id": 1,
     *              "name": "Projeto 1",
     *              "description": "testes do Saúde Digital"
     *          },
     *          {
     *              "id": 2,
     *              "name": "Projeto 2",
     *              "description": "testes do Saúde Digital"
     *          }
     *      ]
     *
     * @apiError {String} type           Tipo de erro, geralmente `BusinessLogic`.
     * @apiError {String} message        Erro ocorrido.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 401 Not Found
     *     {
     *       "type": "Unauthorized",
     *       "message": "Token inválido ou não enviado"
     *     }
     */

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws JsonException
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $userId = (int) $request->getQueryParams()['user_id'];

        /** @var ProjectRepositoryInterface $projectRepository */
        $projectRepository = $this->container->get(ProjectRepositoryInterface::class);
        $projects = $projectRepository->getUserProjects($userId);

        $responseBody = array_map(function(Project $project) {
            $projectArray = $project->jsonSerialize();
            unset($projectArray['owner_user']);
            return $projectArray;
        }, $projects);

        $body = $response->getBody();
        $body->write((string) json_encode($responseBody, JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_OK)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}