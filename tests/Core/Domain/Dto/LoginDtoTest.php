<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Tests\Core\Domain\Dto;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Troupe\TestlabApi\Core\Domain\Dto\LoginDto;
use Troupe\TestlabApi\Core\Domain\Helpers\ArrayHelpers;

class LoginDtoTest extends TestCase
{
    #[Test]
    public function fromArrayShouldBeWork(): void
    {
        $params = [
            'email' => 'tiago@gmail.com',
            'password' => '123456',
        ];

        $loginDto = LoginDto::fromArray($params);

        self::assertSame($params['email'], $loginDto->email);
        self::assertSame($params['password'], $loginDto->password);
    }

    #[Test]
    #[DataProvider('errorProvider')]
    public function fromArrayShouldFail(array $data, string $exceptionMessage): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage($exceptionMessage);

        LoginDto::fromArray($data);
    }

    public static function errorProvider(): array
    {
        $params = [
            'email' => 'tiago@gmail.com',
            'password' => '123456',
        ];

        return [
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