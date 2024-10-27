<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Service;

use Troupe\TestlabApi\TestCases\Domain\Dto\DeleteFolderDto;
use Troupe\TestlabApi\TestCases\Domain\Exception\FolderHasContent;
use Troupe\TestlabApi\TestCases\Domain\Repository\FolderRepositoryInterface;
use Troupe\TestlabApi\TestCases\Domain\Repository\ProjectRepositoryInterface;

readonly class DeleteFolder
{
    public function __construct(
        private FolderRepositoryInterface $folderRepository
    ) {
    }

    public function remove(DeleteFolderDto $deleteFolderDto): array
    {
        $folder = $this->folderRepository->getById($deleteFolderDto->id);

        $folderContent = $this->folderRepository->getFolderContent($folder);
        if (empty($folderContent->folders) && empty($folderContent->testCases)) {
            $removedFolder = $folder->jsonSerialize();
            $this->folderRepository->remove($folder);

            return $removedFolder;
        }

        throw FolderHasContent::throw();
    }
}