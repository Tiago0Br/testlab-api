<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Infrastructure\Persistence;

use Doctrine\ORM\EntityManager;
use Troupe\TestlabApi\TestCases\Domain\Dto\ContentDto;
use Troupe\TestlabApi\TestCases\Domain\Entity\Folder;
use Troupe\TestlabApi\TestCases\Domain\Entity\Project;
use Troupe\TestlabApi\TestCases\Domain\Entity\TestCase;
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

    public function getProjectContent(Project $project): ContentDto
    {
        $content = [];

        $qb = $this->entityManager->createQueryBuilder();
        $qb
            ->select('folder')
            ->from(Folder::class, 'folder')
            ->where("folder.project = :PROJECT")
            ->andWhere("folder.parentFolder IS NULL")
            ->setParameter('PROJECT', $project);

        $content['folders'] = (array) $qb->getQuery()->getResult();
        $content['test_cases'] = [];

        return ContentDto::populate($content);
    }

    public function getFolderContent(Folder $folder): ContentDto
    {
        $content = [];

        if ($folder->getParentFolderId()) {
            $content['parent_folder'] = $this->entityManager->find(Folder::class, $folder->getParentFolderId());
        }

        $qb = $this->entityManager->createQueryBuilder();
        $qb
            ->select('folder')
            ->from(Folder::class, 'folder')
            ->where("folder.parentFolder = :FOLDER")
            ->setParameter('FOLDER', $folder);

        $content['folders'] = (array) $qb->getQuery()->getResult();

        $qb = $this->entityManager->createQueryBuilder();
        $qb
            ->select('testcase')
            ->from(TestCase::class, 'testcase')
            ->where("testcase.testSuite = :TEST_SUITE")
            ->setParameter('TEST_SUITE', $folder);

        $content['test_cases'] = (array) $qb->getQuery()->getResult();

        return ContentDto::populate($content);
    }
}