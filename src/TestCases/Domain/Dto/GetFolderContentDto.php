<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Dto;

use Troupe\TestlabApi\Core\Domain\Helpers\ParamsValidator;

class GetFolderContentDto
{
    private function __construct(
        public readonly int $folderId,
    ) {
    }

    public static function fromArray(array $params): self
    {
        $validator = ParamsValidator::fromArray($params);

        $validator
            ->validateInteger(['id']);

        return new self(
            folderId: (int) $params['id']
        );
    }
}