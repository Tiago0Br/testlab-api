<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Troupe\TestlabApi\TestCases\Domain\Dto\CreateFolderDto;

#[ORM\Table(name: 'folders')]
#[ORM\Entity]
class Folder
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(name: 'title', type: Types::STRING)]
    private string $title;

    #[ORM\OneToOne(targetEntity: Project::class)]
    #[ORM\JoinColumn(name: 'project_id', referencedColumnName: 'id')]
    private Project $project;

    #[ORM\OneToOne(targetEntity: Folder::class)]
    #[ORM\JoinColumn(name: 'folder_id', referencedColumnName: 'id')]
    private ?Folder $folder;

    #[ORM\Column(name: 'is_test_suite', type: Types::INTEGER)]
    private ?int $isTestSuite;

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'project' => $this->project->jsonSerialize(),
            'folder' => $this->folder?->jsonSerialize(),
            'is_test_suite' => $this->isTestSuite,
        ];
    }

    public static function create(
        CreateFolderDto $createFolderDto,
        Project $project,
        Folder $folder = null
    ): self {
        $instance = new self();
        $instance->title = $createFolderDto->title;
        $instance->isTestSuite = $createFolderDto->isTestSuit ?? 0;
        $instance->project = $project;
        $instance->folder = $folder;

        return $instance;
    }
}