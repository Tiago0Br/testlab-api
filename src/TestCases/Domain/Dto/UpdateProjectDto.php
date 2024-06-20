<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Dto;

use Troupe\TestlabApi\Core\Domain\Helpers\ParamsValidator;

class UpdateProjectDto
{
    private function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $description
    ) {
    }

    public static function fromArray(array $params): self
    {
        self::validate($params);

        return new self(
            id: (int) $params['id'],
            name: $params['name'],
            description: $params['description']
        );
    }

    private static function validate(array $params): void
    {
        $validator = ParamsValidator::fromArray($params);

        $validator
            ->validateString(['name', 'description'])
            ->validateInteger(['id']);
    }
}