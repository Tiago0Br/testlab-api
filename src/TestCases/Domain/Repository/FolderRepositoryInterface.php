<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Repository;

use Troupe\TestlabApi\TestCases\Domain\Entity\Folder;

interface FolderRepositoryInterface
{
    public function store(Folder $folder): void;

    public function getById(int $id): Folder;
}