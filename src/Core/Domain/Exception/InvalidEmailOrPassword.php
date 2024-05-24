<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Core\Domain\Exception;

use DomainException;

class InvalidEmailOrPassword extends DomainException
{
    public static function create(): self
    {
        return new self('E-mail e/ou senha inválidos! Por favor, verifique.');
    }
}