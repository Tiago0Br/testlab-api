<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Troupe\TestlabApi\Core\Domain\Entity\User;

#[ORM\Table(name: 'test_case_status')]
#[ORM\Entity]
class TestCaseStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    private int $id;

    #[ORM\ManyToOne(targetEntity: TestCase::class, cascade: ['persist'], inversedBy: 'status')]
    #[ORM\JoinColumn(name: 'test_case_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private TestCase $testCase;

    #[ORM\ManyToOne(targetEntity: User::class, cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'created_by', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ?User $createdBy = null;

    #[ORM\Column(name: 'status', type: Types::STRING)]
    private string $status;

    #[ORM\Column(name: 'note', type: Types::STRING)]
    private ?string $note = null;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_MUTABLE)]
    private DateTime $createdAt;

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'description' => $this->status,
            'note' => $this->note,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
            'created_by' => $this->createdBy?->getName(),
        ];
    }

    public static function create(
        TestCase $testCase,
        User $user,
        string $status,
        ?string $note = null
    ): self {
        $instance = new self();

        $instance->status = $status;
        $instance->note = $note;
        $instance->testCase = $testCase;
        $instance->createdBy = $user;
        $instance->createdAt = new DateTime();

        return $instance;
    }
}