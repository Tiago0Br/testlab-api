<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Dto;

use Troupe\TestlabApi\Core\Domain\Helpers\ParamsValidator;

class DeleteFolderDto
{
    private function __construct(
        public readonly int $id,
        public readonly int $projectId,
    ) {
    }

    public static function fromArray(array $params): self
    {
        self::validate($params);

        return new self(
            id: (int) $params['id'],
            projectId: (int) $params['project_id']
        );
    }

    private static function validate(array $params): void
    {
        $validator = ParamsValidator::fromArray($params);

        $validator->validateInteger(['id', 'project_id']);
    }
}