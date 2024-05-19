<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Repository;

use Troupe\TestlabApi\TestCases\Domain\Entity\TestCase;

interface TestCaseRepositoryInterface
{
    public function store(TestCase $testCase): void;
}