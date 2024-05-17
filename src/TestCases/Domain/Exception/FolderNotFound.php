<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Exception;

use Troupe\TestlabApi\Core\Domain\Exception\NotFoundException;

class FolderNotFound extends NotFoundException
{
    public static function fromId(int $id): self
    {
        return new self(sprintf("Não foi encontrada a pasta com o ID '%d' nesse projeto", $id));
    }
}