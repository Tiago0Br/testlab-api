<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Service;

use Troupe\TestlabApi\TestCases\Domain\Repository\ProjectRepositoryInterface;

class DeleteProject
{
    public function __construct(private readonly ProjectRepositoryInterface $projectRepository)
    {
    }

    public function remove(int $projectId): array
    {
        $project = $this->projectRepository->getById($projectId);
        $removeProject = $project->jsonSerialize();

        $this->projectRepository->remove($project);
        return $removeProject;
    }
}