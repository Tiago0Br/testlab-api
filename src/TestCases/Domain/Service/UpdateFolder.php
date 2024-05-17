<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Service;

use Troupe\TestlabApi\TestCases\Domain\Dto\UpdateFolderDto;
use Troupe\TestlabApi\TestCases\Domain\Entity\Folder;
use Troupe\TestlabApi\TestCases\Domain\Repository\FolderRepositoryInterface;
use Troupe\TestlabApi\TestCases\Domain\Repository\ProjectRepositoryInterface;

class UpdateFolder
{
    public function __construct(
        private readonly FolderRepositoryInterface $folderRepository,
        private readonly ProjectRepositoryInterface $projectRepository
    ) {
    }

    public function update(UpdateFolderDto $updateFolderDto): Folder
    {
        $folder = $this->folderRepository->getById($updateFolderDto->id);
        $project = $this->projectRepository->getById($updateFolderDto->projectId);
        $parentFolder = null;

        if ($updateFolderDto->folderId) {
            $parentFolder = $this->folderRepository->getByIdAndProject(
                id: $updateFolderDto->folderId,
                project: $project
            );
        }

        $folder->update(
            updateFolderDto: $updateFolderDto,
            project: $project,
            folder: $parentFolder
        );

        $this->folderRepository->store($folder);
        return $folder;
    }
}