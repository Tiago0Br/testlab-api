<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Core\Domain\Service;

use Troupe\TestlabApi\Core\Domain\Dto\LoginDto;
use Troupe\TestlabApi\Core\Domain\Entity\User;
use Troupe\TestlabApi\Core\Domain\Exception\InvalidEmailOrPassword;
use Troupe\TestlabApi\Core\Domain\Repository\UserRepositoryInterface;

class LoginService
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function login(LoginDto $loginDto): User
    {
        $user = $this->userRepository->getByEmail($loginDto->email);

        if ($user && $user->validatePassword($loginDto->password)) {
            return $user;
        }

        throw InvalidEmailOrPassword::create();
    }
}