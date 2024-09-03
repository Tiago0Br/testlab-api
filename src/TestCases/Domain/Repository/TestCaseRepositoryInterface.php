<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Repository;

use Troupe\TestlabApi\TestCases\Domain\Entity\Folder;
use Troupe\TestlabApi\TestCases\Domain\Entity\TestCase;

interface TestCaseRepositoryInterface
{
    public function store(TestCase $testCase): void;

    public function getById(int $id): TestCase;

    public function getPreviousTestCase(TestCase $currentTestCase): ?TestCase;

    public function getNextTestCase(TestCase $currentTestCase): ?TestCase;

    /** @return TestCase[] */
    public function getTestCasesByFolder(Folder $folder): array;

    public function remove(TestCase $testCase): void;
}