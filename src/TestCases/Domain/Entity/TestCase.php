<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Troupe\TestlabApi\Core\Domain\Entity\User;
use Troupe\TestlabApi\TestCases\Domain\Dto\ChangeTestCaseStatusDto;
use Troupe\TestlabApi\TestCases\Domain\Dto\CreateTestCaseDto;
use Troupe\TestlabApi\TestCases\Domain\Dto\UpdateTestCaseDto;
use Troupe\TestlabApi\TestCases\Domain\Enum\TestCaseStatusType;

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

    #[ORM\OneToMany(
        targetEntity: TestCaseStatus::class,
        mappedBy: 'testCase',
        cascade: ['persist'],
        orphanRemoval: true
    )]
    private Collection $status;

    private function __construct()
    {
        $this->status = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTestSuite(): Folder
    {
        return $this->testSuite;
    }

    public function jsonSerialize(): array
    {
        $status = array_reverse(array_map(
            fn (TestCaseStatus $status) => $status->jsonSerialize(),
            $this->status->toArray()
        ));

        return [
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->summary,
            'preconditions' => $this->preconditions,
            'status' => $status,
            'test_suite' => $this->testSuite->jsonSerialize(),
        ];
    }

    public static function create(
        CreateTestCaseDto $createTestCaseDto,
        Folder $testSuite,
        User $user
    ): self {
        $instance = new self();
        $instance->title = $createTestCaseDto->title;
        $instance->summary = $createTestCaseDto->summary;
        $instance->preconditions = $createTestCaseDto->preconditions;
        $instance->testSuite = $testSuite;
        $instance->status->add(
            TestCaseStatus::create(
                testCase: $instance,
                user: $user,
                status: TestCaseStatusType::NotExecuted->value
            )
        );

        return $instance;
    }

    public function update(UpdateTestCaseDto $updateTestCaseDto): void
    {
        $this->title = $updateTestCaseDto->title;
        $this->summary = $updateTestCaseDto->summary;
        $this->preconditions = $updateTestCaseDto->preconditions;
    }

    public function addStatus(ChangeTestCaseStatusDto $statusDto, User $user): void
    {
        $this->status->add(
            TestCaseStatus::create(
                testCase: $this,
                user: $user,
                status: $statusDto->status,
                note: $statusDto->note
            )
        );
    }
}