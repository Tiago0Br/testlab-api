<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Service;

use Troupe\TestlabApi\TestCases\Domain\Dto\DeleteFolderDto;
use Troupe\TestlabApi\TestCases\Domain\Exception\FolderHasContent;
use Troupe\TestlabApi\TestCases\Domain\Repository\FolderRepositoryInterface;
use Troupe\TestlabApi\TestCases\Domain\Repository\ProjectRepositoryInterface;

class DeleteFolder
{
    public function __construct(
        private readonly FolderRepositoryInterface $folderRepository,
        private readonly ProjectRepositoryInterface $projectRepository
    ) {
    }

    public function remove(DeleteFolderDto $deleteFolderDto): array
    {
        $project = $this->projectRepository->getById($deleteFolderDto->projectId);
        $folder = $this->folderRepository->getByIdAndProject($deleteFolderDto->id, $project);

        $folderContent = $this->folderRepository->getFolderContent($folder->getProjectId(), $folder);
        if (empty($folderContent->folders && empty($folderContent->testCases))) {
            $removedFolder = $folder->jsonSerialize();
            $this->folderRepository->remove($folder);

            return $removedFolder;
        }

        throw FolderHasContent::fromId($deleteFolderDto->id);
    }
}