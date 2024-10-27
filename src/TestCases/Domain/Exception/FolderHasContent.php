<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Exception;

use DomainException;

class FolderHasContent extends DomainException
{
    public static function throw(): self
    {
        return new self('A pasta não pode ser excluída pois possui conteúdo');
    }
}