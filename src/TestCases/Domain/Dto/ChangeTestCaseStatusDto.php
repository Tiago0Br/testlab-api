<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Dto;

use Assert\Assert;
use Troupe\TestlabApi\Core\Domain\Helpers\ParamsValidator;
use Troupe\TestlabApi\TestCases\Domain\Enum\TestCaseStatusType;

class ChangeTestCaseStatusDto
{
    private function __construct(
        public readonly int $testCaseId,
        public readonly string $status,
        public readonly ?string $note
    ) {
    }

    public static function fromArray(array $params): self
    {
        self::validate($params);

        return new self(
            testCaseId: (int) $params['id'],
            status: $params['status'],
            note: $params['note'] ?? null
        );
    }

    private static function validate(array $params): void
    {
        $validator = ParamsValidator::fromArray($params);

        $validator
            ->validateInteger(['id'])
            ->validateString(['status'])
            ->validateString(
                fields: ['note'],
                required: false
            );

        Assert::that(TestCaseStatusType::statusExists($params['status']))
            ->true("Status '{$params['status']}' inválido");
    }
}