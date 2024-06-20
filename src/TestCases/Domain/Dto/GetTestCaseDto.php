<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Dto;

use Troupe\TestlabApi\Core\Domain\Helpers\ParamsValidator;

class GetTestCaseDto
{
    private function __construct(
        public readonly int $id
    ) {
    }

    public static function fromArray(array $params): self
    {
        $validator = ParamsValidator::fromArray($params);

        $validator->validateInteger(['id']);

        return new self(
            id: (int) $params['id']
        );
    }
}