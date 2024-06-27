<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Infrastructure\Persistence;

use Doctrine\ORM\EntityManager;
use Troupe\TestlabApi\Core\Domain\Entity\User;
use Troupe\TestlabApi\TestCases\Domain\Entity\Project;
use Troupe\TestlabApi\TestCases\Domain\Exception\ProjectNotFound;
use Troupe\TestlabApi\TestCases\Domain\Repository\ProjectRepositoryInterface;

class ProjectRepositoryDoctrineOrm implements ProjectRepositoryInterface
{
    public function __construct(private readonly EntityManager $entityManager)
    {
    }

    public function store(Project $project): void
    {
        $this->entityManager->persist($project);
        $this->entityManager->flush();
    }

    public function getById(int $projectId): Project
    {
        $project = $this->entityManager->find(Project::class, $projectId);

        if ($project instanceof Project) {
            return $project;
        }

        throw ProjectNotFound::fromId($projectId);
    }

    public function remove(Project $project): void
    {
        $this->entityManager->remove($project);
        $this->entityManager->flush();
    }

    public function getUserProjects(int $userId): array
    {
        $qb = $this->entityManager->createQueryBuilder();

        return $qb
            ->select('p')
            ->from(Project::class, 'p')
            ->innerJoin('p.ownerUser', 'u')
            ->where('p.ownerUser = :USER_ID')
            ->setParameter('USER_ID', $userId)
            ->getQuery()
            ->getResult();
    }
}