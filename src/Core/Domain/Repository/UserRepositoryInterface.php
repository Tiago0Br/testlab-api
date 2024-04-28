<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Core\Domain\Repository;

use Troupe\TestlabApi\Core\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function getByEmail(string $email) : array;

    public function store(User $user): void;
}