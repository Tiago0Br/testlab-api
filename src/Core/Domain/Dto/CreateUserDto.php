<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Core\Domain\Dto;

use Troupe\TestlabApi\Core\Domain\Helpers\Validator;

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
        Validator::validateString(
            params: $params,
            fields: ['name', 'email', 'password']
        );
    }
}