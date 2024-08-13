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
use Troupe\TestlabApi\TestCases\Domain\Dto\GetFolderDto;
use Troupe\TestlabApi\TestCases\Domain\Repository\FolderRepositoryInterface;

class GetFolderContentAction
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @api {get} /folders/{id}/content           Busca o conteúdo de dentro de uma pasta
     *
     * @apiExample Exemplo:
     *      http://localhost:8080/folders/1/content
     *
     * @apiName BuscaConteudoDoProjeto
     * @apiGroup CasosDeTestes
     * @apiVersion v1.0.0
     *
     * @apiHeader {String}                      Content-Type Tipo de conteúdo enviado: `application/json`.
     *
     * @apiParam {Int} id                       ID da pasta
     *
     * @apiSuccess {Object|null} parent_folder  Objeto contendo os dados da pasta "pai" ou nulo, caso a pasta esteja na raiz do projeto
     * @apiSuccess {Object[]} folders           Array com as pastas do projeto
     * @apiSuccess {Object[]} test_cases        Array com os casos de testes contidos nessa pasta
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *      {
     *          "parent_folder": null,
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
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws JsonException
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $getFolderContentDto = GetFolderDto::fromArray($args);

        /** @var FolderRepositoryInterface $folderRepository */
        $folderRepository = $this->container->get(FolderRepositoryInterface::class);
        $folder = $folderRepository->getById($getFolderContentDto->folderId);

        $folderContent = $folderRepository->getFolderContent($folder);

        $body = $response->getBody();
        $body->write((string) json_encode($folderContent->jsonSerialize(), JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_OK)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}