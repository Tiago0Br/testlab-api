<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Service;

use Troupe\TestlabApi\TestCases\Domain\Dto\ChangeTestCaseStatusDto;
use Troupe\TestlabApi\TestCases\Domain\Entity\TestCase;
use Troupe\TestlabApi\TestCases\Domain\Repository\TestCaseRepositoryInterface;

class ChangeTestCaseStatus
{
    public function __construct(
        private TestCaseRepositoryInterface $testCaseRepository
    ) {
    }

    public function change(ChangeTestCaseStatusDto $changeTestCaseStatusDto): TestCase
    {
        $testCase = $this->testCaseRepository->getById($changeTestCaseStatusDto->testCaseId);
        $testCase->addStatus($changeTestCaseStatusDto);
        $this->testCaseRepository->store($testCase);

        return $testCase;
    }
}