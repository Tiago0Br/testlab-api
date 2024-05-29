<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Tests\Core\Domain\Dto;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Troupe\TestlabApi\Core\Domain\Dto\GetUserByIdDto;
use Troupe\TestlabApi\Core\Domain\Helpers\ArrayHelpers;

class GetUserByIdDtoTest extends TestCase
{
    #[Test]
    public function fromArrayShouldWork(): void
    {
        $params = [
            'id' => rand(1, 100),
        ];

        $getUserByIdDto = GetUserByIdDto::fromArray($params);

        self::assertSame($params['id'], $getUserByIdDto->id);
    }

    #[Test]
    #[DataProvider('errorProvider')]
    public function fromArrayShouldFail(array $data, string $exceptionMessage): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage($exceptionMessage);

        GetUserByIdDto::fromArray($data);
    }

    public static function errorProvider(): array
    {
        $params = [
            'name' => 'Tiago Lopes',
            'email' => 'tiago@gmail.com',
            'password' => '123456',
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
        ];
    }
}