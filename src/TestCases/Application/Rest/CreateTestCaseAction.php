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
use Troupe\TestlabApi\TestCases\Application\Presenter\TestCasePresenter;
use Troupe\TestlabApi\TestCases\Domain\Dto\CreateTestCaseDto;
use Troupe\TestlabApi\TestCases\Domain\Service\CreateTestCase;

class CreateTestCaseAction
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
        $createTestCaseDto = CreateTestCaseDto::fromArray(array_merge(
            $request->getParsedBody(),
            $args
        ));

        /** @var CreateTestCase $createTestCase */
        $createTestCase = $this->container->get(CreateTestCase::class);
        $testCase = $createTestCase->create($createTestCaseDto);

        $body = $response->getBody();
        $responseBody = TestCasePresenter::format($testCase->jsonSerialize());
        $body->write((string) json_encode($responseBody, JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_CREATED)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}