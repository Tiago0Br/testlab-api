<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Tests\Core\Domain\Dto;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Troupe\TestlabApi\Core\Domain\Dto\CreateUserDto;
use Troupe\TestlabApi\Core\Domain\Helpers\ArrayHelpers;

class CreateUserDtoTest extends TestCase
{
    #[Test]
    public function fromArrayShouldWork(): void
    {
        $params = [
            'name' => 'Tiago Lopes',
            'email' => 'tiago@gmail.com',
            'password' => '123456',
        ];
        $userDto = CreateUserDto::fromArray($params);

        self::assertSame($params['name'], $userDto->name);
        self::assertSame($params['email'], $userDto->email);
        self::assertSame($params['password'], $userDto->password);
    }

    #[Test]
    #[DataProvider('errorProvider')]
    public function fromArrayShouldFail(array $data, string $exceptionMessage): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage($exceptionMessage);

        CreateUserDto::fromArray($data);
    }

    public static function errorProvider(): array
    {
        $params = [
            'name' => 'Tiago Lopes',
            'email' => 'tiago@gmail.com',
            'password' => '123456',
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
            'fromArrayShouldFailWithEmailNull' => [
                'data' => ArrayHelpers::changeValue($params, 'email', null),
                'exceptionMessage' => "O campo 'email' é obrigatório"
            ],
            'fromArrayShouldFailWithEmailEmpty' => [
                'data' => ArrayHelpers::changeValue($params, 'email', ''),
                'exceptionMessage' => "O campo 'email' não pode ser vazio"
            ],
            'fromArrayShouldFailWithEmailHasInvalidType' => [
                'data' => ArrayHelpers::changeValue($params, 'email', 5),
                'exceptionMessage' => "O campo 'email' deve ser do tipo string"
            ],
            'fromArrayShouldFailWithPasswordNull' => [
                'data' => ArrayHelpers::changeValue($params, 'password', null),
                'exceptionMessage' => "O campo 'password' é obrigatório"
            ],
            'fromArrayShouldFailWithPasswordEmpty' => [
                'data' => ArrayHelpers::changeValue($params, 'password', ''),
                'exceptionMessage' => "O campo 'password' não pode ser vazio"
            ],
            'fromArrayShouldFailWithPasswordHasInvalidType' => [
                'data' => ArrayHelpers::changeValue($params, 'password', 5),
                'exceptionMessage' => "O campo 'password' deve ser do tipo string"
            ],
        ];
    }
}