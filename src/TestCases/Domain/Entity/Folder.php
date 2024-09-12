<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Troupe\TestlabApi\TestCases\Domain\Dto\CreateFolderDto;
use Troupe\TestlabApi\TestCases\Domain\Dto\UpdateFolderDto;

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

    #[ORM\ManyToOne(targetEntity: Folder::class)]
    #[ORM\JoinColumn(name: 'parent_folder_id', referencedColumnName: 'id')]
    private ?Folder $parentFolder;

    public function getId(): int
    {
        return $this->id;
    }

    public function getParentFolderId(): ?int
    {
        return $this->parentFolder?->getId();
    }

    public function getProjectId(): int
    {
        return $this->project->getId();
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'project' => $this->project->jsonSerialize(),
            'parent_folder' => $this->parentFolder?->jsonSerialize(),
        ];
    }

    public static function create(
        CreateFolderDto $createFolderDto,
        Project $project,
        Folder $parentFolder = null
    ): self {
        $instance = new self();
        $instance->title = $createFolderDto->title;
        $instance->project = $project;
        $instance->parentFolder = $parentFolder;

        return $instance;
    }

    public function update(
        UpdateFolderDto $updateFolderDto,
        Project $project,
        Folder $parentFolder = null
    ): void {
        $this->title = $updateFolderDto->title;
        $this->project = $project;
        $this->parentFolder = $parentFolder;
    }
}