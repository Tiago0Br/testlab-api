<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Service;

use Troupe\TestlabApi\TestCases\Domain\Dto\CreateFolderDto;
use Troupe\TestlabApi\TestCases\Domain\Entity\Folder;
use Troupe\TestlabApi\TestCases\Domain\Repository\FolderRepositoryInterface;
use Troupe\TestlabApi\TestCases\Domain\Repository\ProjectRepositoryInterface;

class CreateFolder
{
    public function __construct(
        private readonly FolderRepositoryInterface $folderRepository,
        private readonly ProjectRepositoryInterface $projectRepository,
    ) {
    }

    public function create(CreateFolderDto $createFolderDto): Folder
    {
        $project = $this->projectRepository->getById($createFolderDto->projectId);
        $parentFolder = null;

        if ($createFolderDto->folderId) {
            $parentFolder = $this->folderRepository->getById($createFolderDto->folderId);
        }

        $folder = Folder::create(
            createFolderDto: $createFolderDto,
            project: $project,
            folder: $parentFolder
        );

        $this->folderRepository->store($folder);
        return $folder;
    }
}