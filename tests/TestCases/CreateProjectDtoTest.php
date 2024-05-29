<?php

namespace Troupe\TestlabApi\Tests\TestCases;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Troupe\TestlabApi\Core\Domain\Helpers\ArrayHelpers;
use Troupe\TestlabApi\TestCases\Domain\Dto\CreateProjectDto;

class CreateProjectDtoTest extends TestCase
{
    #[Test]
    public function fromArrayShouldWork(): void
    {
        $params = [
            'name' => 'Nome do projeto',
            'description' => 'Descrição do projeto',
            'owner_user_id' => rand(1, 100),
        ];
        $createProjectDto = CreateProjectDto::fromArray($params);

        self::assertSame($params['name'], $createProjectDto->name);
        self::assertSame($params['description'], $createProjectDto->description);
        self::assertSame($params['owner_user_id'], $createProjectDto->ownerUserId);
    }

    #[Test]
    #[DataProvider('errorProvider')]
    public function fromArrayShouldFail(array $data, string $exceptionMessage): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage($exceptionMessage);

        CreateProjectDto::fromArray($data);
    }

    public static function errorProvider(): array
    {
        $params = [
            'name' => 'Nome do projeto',
            'description' => 'Descrição do projeto',
            'owner_user_id' => rand(1, 100),
        ];

        return [
            'fromArrayShouldFailWithNameNull' => [
                'data' => ArrayHelpers::changeValue($params, 'name', null),
                'exceptionMessage' => "O campo 'name' é obrigatório"
            ],
            'fromArrayShouldFailWithNameEmpty' => [
                'data' => ArrayHelpers::changeValue($params, 'name', ''),
                'exceptionMessage' => "O campo 'name' não pode ser vazio"
            ],
            'fromArrayShouldFailWithNameHasInvalidType' => [
                'data' => ArrayHelpers::changeValue($params, 'name', 5),
                'exceptionMessage' => "O campo 'name' deve ser do tipo string"
            ],
            'fromArrayShouldFailWithDescriptionNull' => [
                'data' => ArrayHelpers::changeValue($params, 'description', null),
                'exceptionMessage' => "O campo 'description' é obrigatório"
            ],
            'fromArrayShouldFailWithDescriptionEmpty' => [
                'data' => ArrayHelpers::changeValue($params, 'description', ''),
                'exceptionMessage' => "O campo 'description' não pode ser vazio"
            ],
            'fromArrayShouldFailWithDescriptionHasInvalidType' => [
                'data' => ArrayHelpers::changeValue($params, 'description', 5),
                'exceptionMessage' => "O campo 'description' deve ser do tipo string"
            ],
            'fromArrayShouldFailWithOwnerUserIdNull' => [
                'data' => ArrayHelpers::changeValue($params, 'owner_user_id', null),
                'exceptionMessage' => "O campo 'owner_user_id' é obrigatório"
            ],
            'fromArrayShouldFailWithOwnerUserIdHasInvalidType' => [
                'data' => ArrayHelpers::changeValue($params, 'owner_user_id', 'a'),
                'exceptionMessage' => "O campo 'owner_user_id' deve ser um número"
            ],
        ];
    }
}