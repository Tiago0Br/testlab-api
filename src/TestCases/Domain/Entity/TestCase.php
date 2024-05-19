<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

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
    private string $preconditions;

    #[ORM\OneToOne(targetEntity: Folder::class)]
    #[ORM\JoinColumn(name: 'folder_id', referencedColumnName: 'id')]
    private Folder $testSuite;

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
}