<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Infrastructure\Persistence;

use Doctrine\ORM\EntityManager;
use Troupe\TestlabApi\TestCases\Domain\Entity\Folder;
use Troupe\TestlabApi\TestCases\Domain\Entity\TestCase;
use Troupe\TestlabApi\TestCases\Domain\Exception\TestCaseNotFound;
use Troupe\TestlabApi\TestCases\Domain\Repository\TestCaseRepositoryInterface;

class TestCaseRepositoryDoctrineOrm implements TestCaseRepositoryInterface
{
    public function __construct(private readonly EntityManager $entityManager)
    {
    }

    public function store(TestCase $testCase): void
    {
        $this->entityManager->persist($testCase);
        $this->entityManager->flush();
    }

    public function getById(int $id): TestCase
    {
        $testCase = $this->entityManager->find(TestCase::class, $id);
        if ($testCase instanceof TestCase) {
            return $testCase;
        }

        throw TestCaseNotFound::fromId($id);
    }

    public function remove(TestCase $testCase): void
    {
        $this->entityManager->remove($testCase);
        $this->entityManager->flush();
    }

    public function getTestCasesByFolder(Folder $folder): array
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb
            ->select('testCase')
            ->from(TestCase::class, 'testCase')
            ->where('testCase.testSuite = :FOLDER')
            ->setParameter('FOLDER', $folder);

        return (array) $qb->getQuery()->getResult();
    }
}