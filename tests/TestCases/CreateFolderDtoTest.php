<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Tests\TestCases;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Troupe\TestlabApi\Core\Domain\Helpers\ArrayHelpers;
use Troupe\TestlabApi\TestCases\Domain\Dto\CreateFolderDto;

class CreateFolderDtoTest extends TestCase
{
    #[Test]
    public function fromArrayShouldWork(): void
    {
        $params = [
            'title' => 'Título da pasta',
            'project_id' => rand(1, 100),
            'is_test_suite' => 1,
            'folder_id' => rand(1, 100),
        ];
        $folderDto = CreateFolderDto::fromArray($params);

        self::assertSame($params['title'], $folderDto->title);
        self::assertSame($params['project_id'], $folderDto->projectId);
        self::assertSame($params['is_test_suite'], $folderDto->isTestSuit);
        self::assertSame($params['folder_id'], $folderDto->folderId);
    }

    #[Test]
    #[DataProvider('errorProvider')]
    public function fromArrayShouldFail(array $data, string $exceptionMessage): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage($exceptionMessage);

        CreateFolderDto::fromArray($data);
    }

    public static function errorProvider(): array
    {
        $params = [
            'title' => 'Título da pasta',
            'project_id' => rand(1, 100),
            'is_test_suite' => 1,
            'folder_id' => rand(1, 100),
        ];

        return [
            'fromArrayShouldFailWithTitleNull' => [
                'data' => ArrayHelpers::changeValue($params, 'title', null),
                'exceptionMessage' => "O campo 'title' é obrigatório"
            ],
            'fromArrayShouldFailWithTitleHasInvalidType' => [
                'data' => ArrayHelpers::changeValue($params, 'title', 5),
                'exceptionMessage' => "O campo 'title' deve ser do tipo string"
            ],
            'fromArrayShouldFailWithTitleEmpty' => [
                'data' => ArrayHelpers::changeValue($params, 'title', ''),
                'exceptionMessage' => "O campo 'title' não pode ser vazio"
            ],
            'fromArrayShouldFailWithProjectIdNull' => [
                'data' => ArrayHelpers::changeValue($params, 'project_id', null),
                'exceptionMessage' => "O campo 'project_id' é obrigatório"
            ],
            'fromArrayShouldFailWithProjectIdHasInvalidType' => [
                'data' => ArrayHelpers::changeValue($params, 'project_id', 'a'),
                'exceptionMessage' => "O campo 'project_id' deve ser um número"
            ],
            'fromArrayShouldFailWithIsTestSuiteHasInvalidType' => [
                'data' => ArrayHelpers::changeValue($params, 'is_test_suite', 'a'),
                'exceptionMessage' => "O campo 'is_test_suite' deve ser um número"
            ],
            'fromArrayShouldFailWithIsFolderIdHasInvalidType' => [
                'data' => ArrayHelpers::changeValue($params, 'folder_id', 'a'),
                'exceptionMessage' => "O campo 'folder_id' deve ser um número"
            ],
        ];
    }
}