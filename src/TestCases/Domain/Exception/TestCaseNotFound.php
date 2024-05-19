<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Exception;

use Troupe\TestlabApi\Core\Domain\Exception\NotFoundException;

class TestCaseNotFound extends NotFoundException
{
    public static function fromId(int $id): self
    {
        return new self(sprintf("Não foi encontrado o caso de teste com o ID '%s'", $id));
    }
}