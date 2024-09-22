<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Dto;

use Assert\Assert;
use Troupe\TestlabApi\Core\Domain\Helpers\ParamsValidator;
use Troupe\TestlabApi\TestCases\Domain\Enum\TestCaseStatusType;

readonly class ChangeTestCaseStatusDto
{
    private function __construct(
        public int $testCaseId,
        public int $userId,
        public string $status,
        public ?string $note
    ) {
    }

    public static function fromArray(array $params): self
    {
        self::validate($params);

        return new self(
            testCaseId: (int) $params['id'],
            userId: (int) $params['user_id'],
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