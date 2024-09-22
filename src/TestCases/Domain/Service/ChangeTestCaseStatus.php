<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Service;

use Troupe\TestlabApi\Core\Domain\Repository\UserRepositoryInterface;
use Troupe\TestlabApi\TestCases\Domain\Dto\ChangeTestCaseStatusDto;
use Troupe\TestlabApi\TestCases\Domain\Entity\TestCase;
use Troupe\TestlabApi\TestCases\Domain\Repository\TestCaseRepositoryInterface;

class ChangeTestCaseStatus
{
    public function __construct(
        private readonly TestCaseRepositoryInterface $testCaseRepository,
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    public function change(ChangeTestCaseStatusDto $changeTestCaseStatusDto): TestCase
    {
        $user = $this->userRepository->getById($changeTestCaseStatusDto->userId);

        $testCase = $this->testCaseRepository->getById($changeTestCaseStatusDto->testCaseId);
        $testCase->addStatus($changeTestCaseStatusDto, $user);
        $this->testCaseRepository->store($testCase);

        return $testCase;
    }
}