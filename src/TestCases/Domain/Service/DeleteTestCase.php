<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Service;

use Troupe\TestlabApi\TestCases\Domain\Repository\TestCaseRepositoryInterface;

class DeleteTestCase
{
    public function __construct(private readonly TestCaseRepositoryInterface $testCaseRepository)
    {
    }

    public function delete(int $id): void
    {
        $testCase = $this->testCaseRepository->getById($id);
        $this->testCaseRepository->remove($testCase);
    }
}