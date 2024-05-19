<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Troupe\TestlabApi\TestCases\Domain\Dto\CreateTestCaseDto;
use Troupe\TestlabApi\TestCases\Domain\Dto\UpdateTestCaseDto;

#[ORM\Table(name: 'test_cases')]
#[ORM\Entity]
class TestCase
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(name: 'title', type: Types::STRING)]
    private string $title;

    #[ORM\Column(name: 'summary', type: Types::STRING)]
    private string $summary;

    #[ORM\Column(name: 'preconditions', type: Types::STRING)]
    private ?string $preconditions = null;

    #[ORM\OneToOne(targetEntity: Folder::class)]
    #[ORM\JoinColumn(name: 'test_suite_id', referencedColumnName: 'id')]
    private Folder $testSuite;

    public function getId(): int
    {
        return $this->id;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->summary,
            'preconditions' => $this->preconditions,
            'test_suite' => $this->testSuite->jsonSerialize(),
        ];
    }

    public static function create(
        CreateTestCaseDto $createTestCaseDto,
        Folder $testSuite
    ): self {
        $instance = new self();
        $instance->title = $createTestCaseDto->title;
        $instance->summary = $createTestCaseDto->summary;
        $instance->preconditions = $createTestCaseDto->preconditions;
        $instance->testSuite = $testSuite;

        return $instance;
    }

    public function update(UpdateTestCaseDto $updateTestCaseDto): void
    {
        $this->title = $updateTestCaseDto->title;
        $this->summary = $updateTestCaseDto->summary;
        $this->preconditions = $updateTestCaseDto->preconditions;
    }
}