<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Tests\TestCases\Domain\Dto;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Troupe\TestlabApi\Core\Domain\Helpers\ArrayHelpers;
use Troupe\TestlabApi\TestCases\Domain\Dto\ChangeTestCaseStatusDto;
use Troupe\TestlabApi\TestCases\Domain\Enum\TestCaseStatusType;

class ChangeTestCaseStatusDtoTest extends TestCase
{
    #[Test]
    public function fromArrayShouldWork(): void
    {
        $params = [
            'id' => rand(1, 100),
            'user_id' => rand(1, 100),
            'status' => TestCaseStatusType::NotExecuted->value,
            'note' => 'Nota',
        ];
        $changeTestCaseStatusDto = ChangeTestCaseStatusDto::fromArray($params);

        self::assertSame($params['id'], $changeTestCaseStatusDto->testCaseId);
        self::assertSame($params['user_id'], $changeTestCaseStatusDto->userId);
        self::assertSame($params['status'], $changeTestCaseStatusDto->status);
        self::assertSame($params['note'], $changeTestCaseStatusDto->note);
    }

    #[Test]
    #[DataProvider('errorProvider')]
    public function fromArrayShouldFail(array $data, string $exceptionMessage): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage($exceptionMessage);

        ChangeTestCaseStatusDto::fromArray($data);
    }

    public static function errorProvider(): array
    {
        $params = [
            'id' => rand(1, 100),
            'user_id' => rand(1, 100),
            'status' => TestCaseStatusType::NotExecuted->value,
            'note' => 'Nota',
        ];

        return [
            'fromArrayShouldFailWithIdNull' => [
                'data' => ArrayHelpers::changeValue($params, 'id', null),
                'exceptionMessage' => "O campo 'id' é obrigatório"
            ],
            'fromArrayShouldFailWithIdHasInvalidType' => [
                'data' => ArrayHelpers::changeValue($params, 'id', 'a'),
                'exceptionMessage' => "O campo 'id' deve ser um número"
            ],
            'fromArrayShouldFailWithStatusNull' => [
                'data' => ArrayHelpers::changeValue($params, 'status', null),
                'exceptionMessage' => "O campo 'status' é obrigatório"
            ],
            'fromArrayShouldFailWithStatusEmpty' => [
                'data' => ArrayHelpers::changeValue($params, 'status', ''),
                'exceptionMessage' => "O campo 'status' não pode ser vazio"
            ],
            'fromArrayShouldFailWithStatusHasInvalidType' => [
                'data' => ArrayHelpers::changeValue($params, 'status', 5),
                'exceptionMessage' => "O campo 'status' deve ser do tipo string"
            ],
            'fromArrayShouldFailWithNoteEmpty' => [
                'data' => ArrayHelpers::changeValue($params, 'note', ''),
                'exceptionMessage' => "O campo 'note' não pode ser vazio"
            ],
            'fromArrayShouldFailWithNoteHasInvalidType' => [
                'data' => ArrayHelpers::changeValue($params, 'note', 5),
                'exceptionMessage' => "O campo 'note' deve ser do tipo string"
            ],
        ];
    }
}