<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Dto;

use Troupe\TestlabApi\Core\Domain\Helpers\Validator;

class CreateProjectDto
{
    private function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly int $ownerUserId
    ) {
    }

    public static function fromArray(array $params): self
    {
        self::validate($params);

        return new self(
            name: $params['name'],
            description: $params['description'],
            ownerUserId: (int) $params['user_id']
        );
    }

    private static function validate(array $params): void
    {
        Validator::validateString(
            params: $params,
            fields: ['name', 'description']
        );

        Validator::validateInteger(
            params: $params,
            fields: ['user_id']
        );
    }
}