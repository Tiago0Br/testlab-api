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
use Troupe\TestlabApi\TestCases\Domain\Dto\GetFolderDto;
use Troupe\TestlabApi\TestCases\Domain\Repository\FolderRepositoryInterface;

class GetFolder
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @api {get} /folders/{id}                Busca uma pasta pelo seu ID
     *
     * @apiExample Exemplo:
     *      http://localhost:8080/folders/1
     *
     * @apiName BuscaConteudoDoProjeto
     * @apiGroup CasosDeTestes
     * @apiVersion v1.0.0
     *
     * @apiHeader {String}                      Content-Type Tipo de conteúdo enviado: `application/json`.
     *
     * @apiQuery {Int} id                       ID da pasta
     *
     * @apiSuccess {Object} data                Objeto contendo os dados da pasta
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *      {
     *          "folders": [
     *              {
     *                  "id": 1,
     *                  "title": "Pasta teste",
     *                  "project": {
     *                      "id": 1,
     *                      "name": "Projeto de testes",
     *                      "description": "Descrição do projeto",
     *                      "owner_user": {
     *                          "id": 1,
     *                          "name": "Tiago Lopes",
     *                          "email": "teste2@gmail.com"
     *                      }
     *                  },
     *                  "folder": null,
     *                  "is_test_suite": 1
     *              }
     *          ],
     *          "test_cases": []
     *      }
     *
     * @apiError {String} type           Tipo de erro, geralmente `BusinessLogic`.
     * @apiError {String} message        Erro ocorrido.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "type": "NotFound",
     *       "message": "Pasta não encontrada"
     *     }
     */

    /**
     * @throws JsonException
     * @throws ContainerExceptionInterface
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $getFolderDto = GetFolderDto::fromArray($args);

        /** @var FolderRepositoryInterface $folderRepository */
        $folderRepository = $this->container->get(FolderRepositoryInterface::class);
        $folder = $folderRepository->getById($getFolderDto->folderId);

        $body = $response->getBody();
        $body->write((string) json_encode(
            FolderPresenter::format($folder->jsonSerialize()), JSON_THROW_ON_ERROR)
        );

        return $response
            ->withStatus(StatusCode::HTTP_OK)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}