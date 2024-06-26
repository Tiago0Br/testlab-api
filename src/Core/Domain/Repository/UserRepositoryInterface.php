<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Core\Domain\Repository;

use Troupe\TestlabApi\Core\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function getById(int $id): User;

    public function getByEmail(string $email) : ?User;

    public function store(User $user): void;
}