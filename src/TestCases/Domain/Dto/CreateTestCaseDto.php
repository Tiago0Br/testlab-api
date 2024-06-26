<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Dto;

use Troupe\TestlabApi\Core\Domain\Helpers\ParamsValidator;

class CreateTestCaseDto
{
    private function __construct(
        public readonly string $title,
        public readonly int $testSuiteId,
        public readonly string $summary,
        public readonly ?string $preconditions
    ) {
    }

    public static function fromArray(array $params): self
    {
        self::validate($params);

        return new self(
            title: $params['title'],
            testSuiteId: (int) $params['test_suite_id'],
            summary: $params['summary'],
            preconditions: $params['preconditions'] ?? null
        );
    }

    private static function validate(array $params): void
    {
        $validator = ParamsValidator::fromArray($params);

        $validator
            ->validateString(['title', 'summary'])
            ->validateInteger(['test_suite_id'])
            ->validateString(
                fields: ['preconditions'],
                required: false
            );
    }
}