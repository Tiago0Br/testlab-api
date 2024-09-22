<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Service;

use Troupe\TestlabApi\Core\Domain\Repository\UserRepositoryInterface;
use Troupe\TestlabApi\TestCases\Domain\Dto\CreateTestCaseDto;
use Troupe\TestlabApi\TestCases\Domain\Entity\TestCase;
use Troupe\TestlabApi\TestCases\Domain\Repository\FolderRepositoryInterface;
use Troupe\TestlabApi\TestCases\Domain\Repository\TestCaseRepositoryInterface;

class CreateTestCase
{
    public function __construct(
        private readonly TestCaseRepositoryInterface $testCaseRepository,
        private readonly FolderRepositoryInterface $folderRepository,
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    public function create(CreateTestCaseDto $createTestCaseDto): TestCase
    {
        $user = $this->userRepository->getById($createTestCaseDto->userId);

        $testSuite = $this->folderRepository->getById($createTestCaseDto->testSuiteId);
        $testCase = TestCase::create($createTestCaseDto, $testSuite, $user);
        $this->testCaseRepository->store($testCase);

        return $testCase;
    }
}