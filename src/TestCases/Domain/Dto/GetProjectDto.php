<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Dto;

use Troupe\TestlabApi\Core\Domain\Helpers\Validator;

class GetProjectDto
{
    private function __construct(public readonly int $id)
    {
    }

    public static function fromArray(array $params): self
    {
        Validator::validateInteger(
            params: $params,
            fields: ['id']
        );

        return new self(
            id: (int) $params['id']
        );
    }
}