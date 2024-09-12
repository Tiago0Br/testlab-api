<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Dto;

use Assert\Assert;
use Troupe\TestlabApi\Core\Domain\Helpers\ParamsValidator;

class UpdateFolderDto
{
    private function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly int $projectId,
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
            folderId: $params['folder_id'] ? (int) $params['folder_id'] : null
        );
    }

    private static function validate(array $params): void
    {
        $validator = ParamsValidator::fromArray($params);

        $validator
            ->validateString(['title'])
            ->validateInteger(['id', 'project_id'])
            ->validateInteger(
                fields: ['folder_id'],
                required: false
            );

        Assert::that($params['folder_id'] != $params['id'])
            ->true('A pasta não pode ser filha dela mesma');
    }
}