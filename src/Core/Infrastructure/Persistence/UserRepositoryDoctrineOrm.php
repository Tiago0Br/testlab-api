<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Core\Infrastructure\Persistence;

use Doctrine\ORM\EntityManager;
use Troupe\TestlabApi\Core\Domain\Entity\User;
use Troupe\TestlabApi\Core\Domain\Exception\UserNotFound;
use Troupe\TestlabApi\Core\Domain\Repository\UserRepositoryInterface;

class UserRepositoryDoctrineOrm implements UserRepositoryInterface
{
    public function __construct(private readonly EntityManager $entityManager)
    {
    }

    public function store(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function getByEmail(string $email): ?User
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
    }

    public function getById(int $id): User
    {
        $user = $this->entityManager->find(User::class, $id);

        if ($user instanceof User) {
            return $user;
        }

        throw UserNotFound::fromId($id);
    }
}