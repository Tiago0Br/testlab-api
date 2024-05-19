<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'test_case_status')]
#[ORM\Entity]
class TestCaseStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    private int $id;

    #[ORM\OneToOne(targetEntity: TestCase::class, cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'test_case_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private TestCase $testCase;

    #[ORM\Column(name: 'status', type: Types::STRING)]
    private string $status;

    #[ORM\Column(name: 'note', type: Types::STRING)]
    private string $note;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_MUTABLE)]
    private DateTimeImmutable $createdAt;

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'test_case' => $this->testCase->jsonSerialize(),
            'status' => $this->status,
            'note' => $this->note,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
        ];
    }
}