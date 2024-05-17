<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Infrastructure\Persistence;

use Doctrine\ORM\EntityManager;
use Troupe\TestlabApi\TestCases\Domain\Entity\Folder;
use Troupe\TestlabApi\TestCases\Domain\Entity\Project;
use Troupe\TestlabApi\TestCases\Domain\Exception\FolderNotFound;
use Troupe\TestlabApi\TestCases\Domain\Repository\FolderRepositoryInterface;

class FolderRepositoryDoctrineOrm implements FolderRepositoryInterface
{
    public function __construct(private readonly EntityManager $entityManager)
    {
    }

    public function store(Folder $folder): void
    {
        $this->entityManager->persist($folder);
        $this->entityManager->flush();
    }

    public function getById(int $id): Folder
    {
        $folder = $this->entityManager->find(Folder::class, $id);

        if ($folder instanceof Folder) {
            return $folder;
        }

        throw FolderNotFound::fromId($id);
    }

    public function getByIdAndProject(int $id, Project $project): Folder
    {
        $folder = $this->entityManager->getRepository(Folder::class)->findOneBy([
            'id' => $id,
            'project' => $project
        ]);

        if ($folder instanceof Folder) {
            return $folder;
        }

        throw FolderNotFound::fromId($id);
    }
}