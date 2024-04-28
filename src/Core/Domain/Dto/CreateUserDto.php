<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Core\Domain\Dto;

use Assert\Assert;
class CreateUserDto
{
    private function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password
    ) {
    }

    public static function fromArray(array $params): self
    {
        self::validate($params);

        return new self(
            name: $params['name'],
            email: $params['email'],
            password: $params['password']
        );
    }

    private static function validate(array $params): void
    {
        array_map(static function ($key) use ($params) {
            Assert::that($params[$key])
                ->notNull("O campo '$key' é obrigatório")
                ->string("O campo '$key' deve ser do tipo string")
                ->notEmpty("O campo '$key' não pode ser vazio");
        }, ['name', 'email', 'password']);
    }
}