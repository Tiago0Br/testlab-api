<?php

namespace Troupe\TestlabApi\TestCases\Application\Rest;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\StatusCode;
use Troupe\TestlabApi\TestCases\Domain\Enum\TestCaseStatusType;

class ListTestCaseStatusAction
{
    public function __construct()
    {
    }

    /**
     * @api {get} /test_cases/status         Lista os status disponíveis que um caso de testes pode ter
     *
     * @apiExample Exemplo:
     *      http://localhost:8080/test_cases/status
     *
     * @apiName ListaStatusCasoDeTeste
     * @apiGroup CasosDeTestes
     * @apiVersion v1.0.0
     *
     * @apiHeader {String}              Content-Type Tipo de conteúdo enviado: `application/json`.
     *
     * @apiSuccess {String} value                       Descrição do status em caixa alta
     * @apiSuccess {String} label                       Descrição do status no formato capitalizado
     * @apiSuccess {Boolean} disabled                   Status é selecionável ou não
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 Ok
     *      [
     *          {
     *              "value": "NÃO EXECUTADO",
     *              "label": "Não Executado",
     *              "disabled": true
     *          },
     *          {
     *              "value": "PASSOU",
     *              "label": "Passou",
     *              "disabled": false
     *          },
     *          {
     *              "value": "COM FALHA",
     *              "label": "Com Falha",
     *              "disabled": false
     *          },
     *          {
     *              "value": "BLOQUEADO",
     *              "label": "Bloqueado",
     *              "disabled": false
     *          },
     *          {
     *              "value": "EM EXECUÇÃO",
     *              "label": "Em Execução",
     *              "disabled": false
     *          },
     *          {
     *              "value": "CANCELADO",
     *              "label": "Cancelado",
     *              "disabled": false
     *          },
     *          {
     *              "value": "LIBERADO",
     *              "label": "Liberado",
     *              "disabled": false
     *          }
     *      ]
     */

    public function __invoke(Request $request, Response $response): Response
    {
        $body = $response->getBody();
        $body->write((string) json_encode(TestCaseStatusType::listStatusAndLabel()));

        return $response
            ->withStatus(StatusCode::HTTP_OK)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}