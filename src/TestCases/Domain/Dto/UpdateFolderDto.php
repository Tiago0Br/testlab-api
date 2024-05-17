<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Dto;

use Troupe\TestlabApi\Core\Domain\Helpers\Validator;

class UpdateFolderDto
{
    private function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly int $projectId,
        public readonly ?int $isTestSuit,
        public readonly ?int $folderId
    ) {
    }

    public static function fromArray(array $params): self
    {
        self::validate($params);

        return new self(
            id: (int) $params['id'],
            title: $params['title'],
            projectId: (int) $params['project_id'],
            isTestSuit: $params['is_test_suite'] ? (int) $params['is_test_suite'] : null,
            folderId: $params['folder_id'] ? (int) $params['folder_id'] : null
        );
    }

    private static function validate(array $params): void
    {
        Validator::validateString(
            params: $params,
            fields: ['title']
        );

        Validator::validateInteger(
            params: $params,
            fields: ['id', 'project_id']
        );

        Validator::validateInteger(
            params: $params,
            fields: ['folder_id', 'is_test_suite'],
            required: false
        );
    }
}