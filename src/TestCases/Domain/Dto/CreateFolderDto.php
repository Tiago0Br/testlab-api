<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Dto;

use Troupe\TestlabApi\Core\Domain\Helpers\Validator;

class CreateFolderDto
{
    private function __construct(
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
            title: $params['title'],
            projectId: (int) $params['project_id'],
            isTestSuit: $params['is_test_suit'] ? (int) $params['is_test_suit'] : null,
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
            fields: ['project_id']
        );

        Validator::validateInteger(
            params: $params,
            fields: ['folder_id', 'is_test_suit'],
            required: false
        );
    }
}