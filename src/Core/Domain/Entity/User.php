<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Core\Domain\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Troupe\TestlabApi\Core\Domain\Dto\CreateUserDto;

#[ORM\Table(name: 'users')]
#[ORM\Entity]
class User
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(name: 'name', type: Types::STRING)]
    private string $name;

    #[ORM\Column(name: 'email', type: Types::STRING)]
    private string $email;

    #[ORM\Column(name: 'password', type: Types::STRING)]
    private string $password;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function validatePassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }

    public static function create(CreateUserDto $createUserDto): self
    {
        $user = new self();

        $user->name = $createUserDto->name;
        $user->email = $createUserDto->email;
        $user->password = password_hash($createUserDto->password, PASSWORD_BCRYPT);

        return $user;
    }
}