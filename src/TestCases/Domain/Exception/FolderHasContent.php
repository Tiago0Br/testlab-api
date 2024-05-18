<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Exception;

use DomainException;

class FolderHasContent extends DomainException
{
    public static function fromId(int $id): self
    {
        return new self(sprintf("A pasta de ID '%s' não pode ser excluída pois possui conteúdo", $id));
    }
}