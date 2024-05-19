<?php

namespace Troupe\TestlabApi\TestCases\Domain\Dto;

use Troupe\TestlabApi\Core\Domain\Helpers\Validator;

class UpdateTestCaseDto
{
    private function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $summary,
        public readonly ?string $preconditions,
    ) {
    }

    public static function fromArray(array $params): self
    {
        self::validate($params);

        return new self(
            id: (int) $params['id'],
            title: $params['title'],
            summary: $params['summary'],
            preconditions: $params['preconditions'] ?? null,
        );
    }

    private static function validate(array $params): void
    {
        Validator::validateInteger(
            params: $params,
            fields: ['id']
        );

        Validator::validateString(
            params: $params,
            fields: ['title', 'summary']
        );

        Validator::validateString(
            params: $params,
            fields: ['preconditions'],
            required: false
        );
    }
}