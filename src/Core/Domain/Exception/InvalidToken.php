<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Core\Domain\Exception;

class InvalidToken extends UnauthorizedException
{
    public static function create(): self
    {
        return new self('Token inválido ou não enviado');
    }
}