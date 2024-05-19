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
use Troupe\TestlabApi\TestCases\Domain\Dto\UpdateTestCaseDto;
use Troupe\TestlabApi\TestCases\Domain\Service\UpdateTestCase;

class UpdateTestCaseAction
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
        $updateTestCaseDto = UpdateTestCaseDto::fromArray(array_merge(
            (array) $request->getParsedBody(),
            $args
        ));

        /** @var UpdateTestCase $updateTestCase */
        $updateTestCase = $this->container->get(UpdateTestCase::class);
        $testCase = $updateTestCase->update($updateTestCaseDto);

        $body = $response->getBody();
        $responseBody = TestCasePresenter::format($testCase->jsonSerialize());
        $body->write((string) json_encode($responseBody, JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_OK)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}