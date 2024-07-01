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

    public function remove(Folder $folder): void
    {
        $this->entityManager->remove($folder);
        $this->entityManager->flush();
    }

    public function getSubfoldersByFolderId(int $id): array
    {
        $qb = $this->entityManager->createQueryBuilder();

        $query = $qb
            ->select('folder')
            ->from(Folder::class, 'folder')
            ->innerJoin('folder.folder', 'parentFolder')
            ->where('parentFolder.id = :ID')
            ->setParameter('ID', $id)
            ->getQuery();

        return (array) $query->getResult();
    }

    public function getFolderContent(int $projectId, ?Folder $folder): array
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb
            ->select('folder')
            ->from(Folder::class, 'folder')
            ->innerJoin('folder.project', 'project')
            ->where('project.id = :PROJECT_ID')
            ->setParameter('PROJECT_ID', $projectId);

        if ($folder) {
            $qb
                ->andWhere("folder.parentFolder = :FOLDER")
                ->setParameter('FOLDER', $folder);
        } else {
            $qb
                ->andWhere("folder.parentFolder IS null");
        }

        return (array) $qb->getQuery()->getResult();
    }
}