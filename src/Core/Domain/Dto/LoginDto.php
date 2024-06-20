<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Core\Domain\Dto;

use Troupe\TestlabApi\Core\Domain\Helpers\ParamsValidator;

class LoginDto
{
    private function __construct(
        public readonly string $email,
        public readonly string $password
    ) {
    }

    public static function fromArray(array $params): self
    {
        $validator = ParamsValidator::fromArray($params);

        $validator->validateString(['email', 'password']);

        return new self(
            email: $params['email'],
            password: $params['password']
        );
    }
}