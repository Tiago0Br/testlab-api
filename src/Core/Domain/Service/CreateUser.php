<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Core\Domain\Service;

use Troupe\TestlabApi\Core\Domain\Dto\CreateUserDto;
use Troupe\TestlabApi\Core\Domain\Entity\User;
use Troupe\TestlabApi\Core\Domain\Exception\EmailAlreadyRegistered;
use Troupe\TestlabApi\Core\Domain\Repository\UserRepositoryInterface;

class CreateUser
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function create(CreateUserDto $createUserDto): User
    {
        $user = User::create($createUserDto);
        $userWithSameEmail = $this->userRepository->getByEmail($createUserDto->email);

        if (! $userWithSameEmail) {
            $this->userRepository->store($user);

            return $user;
        }

        throw EmailAlreadyRegistered::fromEmail($createUserDto->email);
    }
}