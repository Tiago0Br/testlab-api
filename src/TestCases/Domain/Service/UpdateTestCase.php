<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Service;

use Troupe\TestlabApi\TestCases\Domain\Dto\UpdateTestCaseDto;
use Troupe\TestlabApi\TestCases\Domain\Entity\TestCase;
use Troupe\TestlabApi\TestCases\Domain\Repository\TestCaseRepositoryInterface;

class UpdateTestCase
{
    public function __construct(private readonly TestCaseRepositoryInterface $testCaseRepository)
    {
    }

    public function update(UpdateTestCaseDto $updateTestCaseDto): TestCase
    {
        $testCase = $this->testCaseRepository->getById($updateTestCaseDto->id);
        $testCase->update($updateTestCaseDto);
        $this->testCaseRepository->store($testCase);

        return $testCase;
    }
}