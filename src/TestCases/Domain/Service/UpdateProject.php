<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Service;

use Troupe\TestlabApi\TestCases\Domain\Dto\UpdateProjectDto;
use Troupe\TestlabApi\TestCases\Domain\Entity\Project;
use Troupe\TestlabApi\TestCases\Domain\Repository\ProjectRepositoryInterface;

class UpdateProject
{
    public function __construct(private readonly ProjectRepositoryInterface $projectRepository)
    {
    }

    public function update(UpdateProjectDto $projectDto): Project
    {
        $project = $this->projectRepository->getById($projectDto->id);
        $project->update($projectDto);
        $this->projectRepository->store($project);

        return $project;
    }
}