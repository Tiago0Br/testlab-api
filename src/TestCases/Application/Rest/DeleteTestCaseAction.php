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
use Troupe\TestlabApi\TestCases\Domain\Dto\GetTestCaseDto;
use Troupe\TestlabApi\TestCases\Domain\Service\DeleteTestCase;

class DeleteTestCaseAction
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws JsonException
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $testCaseDto = GetTestCaseDto::fromArray($args);

        /** @var DeleteTestCase $deleteTestCase */
        $deleteTestCase = $this->container->get(DeleteTestCase::class);
        $deleteTestCase->delete($testCaseDto->id);

        $body = $response->getBody();
        $responseBody = [
            'id' => $testCaseDto->id,
        ];
        $body->write((string) json_encode($responseBody, JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_OK)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}