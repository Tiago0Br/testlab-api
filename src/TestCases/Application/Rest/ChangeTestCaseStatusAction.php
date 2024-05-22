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