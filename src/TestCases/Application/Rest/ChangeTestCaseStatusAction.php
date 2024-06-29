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
use Troupe\TestlabApi\TestCases\Domain\Dto\ChangeTestCaseStatusDto;
use Troupe\TestlabApi\TestCases\Domain\Service\ChangeTestCaseStatus;

class ChangeTestCaseStatusAction
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @api {post} /test_cases/{id}/status         Altera o status de um caso de teste
     *
     * @apiExample Exemplo:
     *      http://localhost:8080/test_cases/123/status
     *
     * @apiName AlteraStatusCasoDeTeste
     * @apiGroup CasosDeTestes
     * @apiVersion v1.0.0
     *
     * @apiHeader {String}              Content-Type Tipo de conteúdo enviado: `application/json`.
     *
     * @apiParam {String} id            ID do caso de testes
     * @apiBody {String|null} note      Observação sobre a mudança de status
     *
     * @apiParamExample {json} Request-Example:
     *      {
     *          "status": "EM EXECUÇÃO",
     *          "note": "O teste está rolando"
     *      }
     *
     * @apiSuccess {Int} id                         ID do caso de testes.
     * @apiSuccess {String}                         title Título do caso de testes
     * @apiSuccess {String} summary                 Resumo do caso de testes
     * @apiSuccess {String|null} preconditions      Pré-condições do caso de testes
     * @apiSuccess {Object[]} status                Situação do caso de testes ("EM EXECUÇÃO", "CANCELADO", etc)
     * @apiSuccess {Int} status.id                  ID do status do caso de testes
     * @apiSuccess {String} status.status           Situação do caso de testes
     * @apiSuccess {String|null} note               Observações sobre a situação do caso de testes
     * @apiSuccess {String} created_at              Data em que o status foi alterado
     * @apiSuccess {Object} test_suite              Suíte de testes onde o teste se encontra
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 201 Created
     *      {
     *          "id": 1,
     *          "title": "Título do caso de testes",
     *          "summary": "Resumo do teste",
     *          "preconditions": null,
     *          "status": [
     *              {
     *                  "id": 2,
     *                  "status": "EM EXECUÇÃO",
     *                  "note": "O teste está rolando",
     *                  "created_at": "2024-06-23 20:40:22"
     *              },
     *              {
     *                  "id": 1,
     *                  "status": "NÃO EXECUTADO",
     *                  "note": null,
     *                  "created_at": "2024-06-23 20:40:17"
     *              }
     *          ],
     *          "test_suite": {
     *              "id": 1,
     *              "title": "Pasta teste",
     *              "project": {
     *                  "id": 1,
     *                  "name": "Projeto legal de outro usuário",
     *                  "description": "testes do Saúde Digital",
     *                  "owner_user": {
     *                      "id": 1,
     *                      "name": "Tiago Lopes",
     *                      "email": "teste2@gmail.com"
     *                  }
     *              },
     *              "folder": null,
     *              "is_test_suite": 1
     *          }
     *      }
     *
     * @apiError {String} type           Tipo de erro, geralmente `BusinessLogic`.
     * @apiError {String} message        Erro ocorrido.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "type": "NotFound",
     *       "message": "Caso de testes não encontrado"
     *     }
     */

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws JsonException
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $changeTestCaseStatusDto = ChangeTestCaseStatusDto::fromArray(array_merge(
            $args,
            (array) $request->getParsedBody()
        ));

        /** @var ChangeTestCaseStatus $changeTestCaseStatus */
        $changeTestCaseStatus = $this->container->get(ChangeTestCaseStatus::class);
        $testCase = $changeTestCaseStatus->change($changeTestCaseStatusDto);

        $body = $response->getBody();
        $body->write((string) json_encode($testCase->jsonSerialize(), JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_OK)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}