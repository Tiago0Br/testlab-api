<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Repository;

use Troupe\TestlabApi\TestCases\Domain\Entity\Folder;
use Troupe\TestlabApi\TestCases\Domain\Entity\Project;

interface FolderRepositoryInterface
{
    public function store(Folder $folder): void;

    public function getById(int $id): Folder;

    public function getByIdAndProject(int $id, Project $project): Folder;

    public function getSubfoldersByFolderId(int $id): array;

    public function remove(Folder $folder): void;
}