<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Repository;

use Troupe\TestlabApi\TestCases\Domain\Entity\Project;

interface ProjectRepositoryInterface
{
    public function store(Project $project): void;

    public function getById(int $projectId): Project;

    /** @return Project[] */
    public function getUserProjects(int $userId): array;

    public function remove(Project $project): void;
}