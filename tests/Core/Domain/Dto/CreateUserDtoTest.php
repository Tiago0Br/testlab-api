<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Tests\Core\Domain\Dto;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Troupe\TestlabApi\Core\Domain\Dto\CreateUserDto;

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

        $this->assertSame($params['name'], $userDto->name);
        $this->assertSame($params['email'], $userDto->email);
        $this->assertSame($params['password'], $userDto->password);
    }

    #[Test]
    #[DataProvider('errorProvider')]
    public function fromArrayShouldFail(array $data, string $exceptionMessage): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($exceptionMessage);

        CreateUserDto::fromArray($data);
    }

    public static function errorProvider(): array
    {
        $params = [
            'name' => 'Tiago Lopes',
            'email' => 'tiago@gmail.com',
            'password' => '123456',
        ];

        $changeValues = static function ($key, $value) use ($params) {
            return array_merge($params, [$key => $value]);
        };

        return [
            'fromArrayShouldFailWithNameNull' => [
                'data' => $changeValues('name', null),
                'exceptionMessage' => "O campo 'name' é obrigatório"
            ],
            'fromArrayShouldFailWithNameEmpty' => [
                'data' => $changeValues('name', ''),
                'exceptionMessage' => "O campo 'name' não pode ser vazio"
            ],
            'fromArrayShouldFailWithNameHasInvalidType' => [
                'data' => $changeValues('name', 5),
                'exceptionMessage' => "O campo 'name' deve ser do tipo string"
            ],
            'fromArrayShouldFailWithEmailNull' => [
                'data' => $changeValues('email', null),
                'exceptionMessage' => "O campo 'email' é obrigatório"
            ],
            'fromArrayShouldFailWithEmailEmpty' => [
                'data' => $changeValues('email', ''),
                'exceptionMessage' => "O campo 'email' não pode ser vazio"
            ],
            'fromArrayShouldFailWithEmailHasInvalidType' => [
                'data' => $changeValues('email', 5),
                'exceptionMessage' => "O campo 'email' deve ser do tipo string"
            ],
            'fromArrayShouldFailWithPasswordNull' => [
                'data' => $changeValues('password', null),
                'exceptionMessage' => "O campo 'password' é obrigatório"
            ],
            'fromArrayShouldFailWithPasswordEmpty' => [
                'data' => $changeValues('password', ''),
                'exceptionMessage' => "O campo 'password' não pode ser vazio"
            ],
            'fromArrayShouldFailWithPasswordHasInvalidType' => [
                'data' => $changeValues('password', 5),
                'exceptionMessage' => "O campo 'password' deve ser do tipo string"
            ],
        ];
    }
}