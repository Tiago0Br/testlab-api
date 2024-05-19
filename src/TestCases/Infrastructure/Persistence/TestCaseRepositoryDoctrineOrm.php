<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Infrastructure\Persistence;

use Doctrine\ORM\EntityManager;
use Troupe\TestlabApi\TestCases\Domain\Entity\TestCase;
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
}