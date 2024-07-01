<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Application\Rest;

use Troupe\TestlabApi\Core\Domain\Helpers\ParamsValidator;

class GetFolderContentDto
{
    private function __construct(
        public readonly int $projectId,
        public readonly ?int $folderId,
    ) {
    }

    public static function fromArray(array $params): self
    {
        $validator = ParamsValidator::fromArray($params);

        $validator
            ->validateInteger(['id'])
            ->validateInteger(['folder_id'], false);

        return new self(
            projectId: (int) $params['id'],
            folderId: $params['folder_id'] ? (int) $params['folder_id'] : null,
        );
    }
}