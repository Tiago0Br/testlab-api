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
use Troupe\TestlabApi\TestCases\Domain\Dto\GetTestCaseDto;
use Troupe\TestlabApi\TestCases\Domain\Repository\TestCaseRepositoryInterface;

class GetTestCaseAction
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
        $getTestCaseDto = GetTestCaseDto::fromArray($args);

        /** @var TestCaseRepositoryInterface $testCaseRepository */
        $testCaseRepository = $this->container->get(TestCaseRepositoryInterface::class);
        $testCase = $testCaseRepository->getById($getTestCaseDto->id);
        $nextTestCase = $testCaseRepository->getNextTestCase($testCase);

        $body = $response->getBody();
        $responseBody = array_merge(
            TestCasePresenter::format($testCase->jsonSerialize()),
            [
                'next_test_case' => $nextTestCase
                    ? TestCasePresenter::formatWithoutHistory($nextTestCase->jsonSerialize())
                    : null,
            ],
        );
        $body->write((string) json_encode($responseBody, JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_OK)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}