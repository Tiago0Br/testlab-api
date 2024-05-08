<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Service;

use Troupe\TestlabApi\Core\Domain\Repository\UserRepositoryInterface;
use Troupe\TestlabApi\TestCases\Domain\Dto\CreateProjectDto;
use Troupe\TestlabApi\TestCases\Domain\Entity\Project;
use Troupe\TestlabApi\TestCases\Domain\Repository\ProjectRepositoryInterface;

class CreateProject
{
    public function __construct(
        private readonly ProjectRepositoryInterface $projectRepository,
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    public function create(CreateProjectDto $createProjectDto): Project
    {
        $user = $this->userRepository->getById($createProjectDto->ownerUserId);
        $project = Project::create($createProjectDto, $user);
        $this->projectRepository->store($project);

        return $project;
    }
}