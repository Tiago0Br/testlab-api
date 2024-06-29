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
use Troupe\TestlabApi\TestCases\Domain\Dto\GetProjectDto;
use Troupe\TestlabApi\TestCases\Domain\Entity\Folder;
use Troupe\TestlabApi\TestCases\Domain\Repository\FolderRepositoryInterface;

class GetProjectFoldersAction
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @api {get} /projects/{id}/folders           Busca as pastas de um projeto
     *
     * @apiExample Exemplo:
     *      http://localhost:8080/projects/1/folders
     *
     * @apiName BuscaPastasDoProjeto
     * @apiGroup CasosDeTestes
     * @apiVersion v1.0.0
     *
     * @apiHeader {String}              Content-Type Tipo de conteúdo enviado: `application/json`.
     *
     * @apiParam {String} id            ID do projeto
     *
     * @apiSuccess {Object[]} data              Array com os dados das pastas do projeto
     * @apiSuccess {Int} data.id                ID da pasta
     * @apiSuccess {String} data.title          Título da pasta
     * @apiSuccess {String|null} data.folder    Pasta "pai" ou nulo, caso a pasta esteja na raiz do projeto
     * @apiSuccess {Int} data.is_test_suite     Parâmetro para dizer se a pasta possui casos de testes ou não
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *      [
     *          {
     *              "id": 1,
     *              "title": "Pasta teste",
     *              "folder": null,
     *              "is_test_suite": 1
     *          }
     *      ]
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
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws JsonException
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $getProjectDto = GetProjectDto::fromArray($args);

        /** @var FolderRepositoryInterface $folderRepository */
        $folderRepository = $this->container->get(FolderRepositoryInterface::class);
        $folders = $folderRepository->getProjectFolders($getProjectDto->id);

        $responseBody = array_map(fn(Folder $folder) => FolderPresenter::format($folder->jsonSerialize()), $folders);

        $body = $response->getBody();
        $body->write((string) json_encode($responseBody, JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_OK)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}