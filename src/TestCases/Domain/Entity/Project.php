<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\TestCases\Domain\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Troupe\TestlabApi\Core\Domain\Entity\User;
use Troupe\TestlabApi\TestCases\Domain\Dto\CreateProjectDto;
use Troupe\TestlabApi\TestCases\Domain\Dto\UpdateProjectDto;

#[ORM\Table(name: 'projects')]
#[ORM\Entity]
class Project
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(name: 'name', type: Types::STRING)]
    private string $name;

    #[ORM\Column(name: 'description', type: Types::STRING)]
    private string $description;

    #[ORM\OneToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'owner_user_id', referencedColumnName: 'id')]
    private User $ownerUser;

    public function getId(): int
    {
        return $this->id;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'owner_user' => $this->ownerUser->jsonSerialize(),
        ];
    }

    public static function create(CreateProjectDto $projectDto, User $user): self
    {
        $instance = new self();
        $instance->name = $projectDto->name;
        $instance->description = $projectDto->description;
        $instance->ownerUser = $user;

        return $instance;
    }

    public function update(UpdateProjectDto $updateProjectDto): void
    {
        $this->name = $updateProjectDto->name;
        $this->description = $updateProjectDto->description;
    }
}