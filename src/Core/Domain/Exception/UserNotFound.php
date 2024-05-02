<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Core\Domain\Exception;

class UserNotFound extends NotFoundException
{
    public static function fromId(int $id) : self
    {
        return new self(sprintf('Usuário com o id "%s" não encontrado.', $id));
    }
}