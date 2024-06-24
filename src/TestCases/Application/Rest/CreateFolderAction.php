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
use Troupe\TestlabApi\TestCases\Application\Presenter\FolderPresenter;
use Troupe\TestlabApi\TestCases\Domain\Dto\CreateFolderDto;
use Troupe\TestlabApi\TestCases\Domain\Service\CreateFolder;

class CreateFolderAction
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @api {post} /folders             Cria uma pasta no projeto
     *
     * @apiName CriaPasta
     * @apiGroup Pastas
     * @apiVersion v1.0.0
     *
     * @apiHeader {String}              Content-Type Tipo de conteúdo enviado: `application/json`.
     *
     * @apiBody {String} title              Nome da pasta
     * @apiBody {Int} project_id            ID do projeto a qual a pasta pertence
     * @apiBody {Int|null} folder_id        ID da pasta "pai"
     * @apiBody {Int|null} is_test_suite    Diz se a pasta é uma suíte de testes ou não (1- Sim, 0 - Não)
     *
     * @apiParamExample {json} Request-Example:
     *      {
     *          "title": "Pasta teste",
     *          "folder_id": null,
     *          "project_id": 1,
     *          "is_test_suite": 1
     *      }
     *
     * @apiSuccess {Object} message Mensagem de retorno da API.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 201 Created
     *      {
     *          "id": 1,
     *          "title": "Vamos ver se vai dar bom",
     *          "project": {
     *              "id": 1,
     *              "name": "Projeto legal de outro usuário",
     *              "description": "testes do Saúde Digital",
     *              "owner_user": {
     *                  "id": 1,
     *                  "name": "Tiago Lopes",
     *                  "email": "teste2@gmail.com"
     *              }
     *          },
     *          "folder": null,
     *          "is_test_suite": 1
     *      }
     *
     * @apiError {String} type           Tipo de erro, geralmente `BusinessLogic`.
     * @apiError {String} message        Erro ocorrido.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 409 Conflict
     *     {
     *       "type": "BusinessLogic",
     *       "message": "Já possui uma pasta com esse nome"
     *     }
     */

    /**
     * @throws JsonException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $createFolderDto = CreateFolderDto::fromArray((array) $request->getParsedBody());

        /** @var CreateFolder $createFolder */
        $createFolder = $this->container->get(CreateFolder::class);
        $folder = $createFolder->create($createFolderDto);

        $body = $response->getBody();
        $body->write((string) json_encode(FolderPresenter::format(
            $folder->jsonSerialize()), JSON_THROW_ON_ERROR
        ));

        return $response
            ->withStatus(StatusCode::HTTP_CREATED)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}