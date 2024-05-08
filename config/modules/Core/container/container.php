<?php

use Psr\Container\ContainerInterface;
use Troupe\TestlabApi\Core\Domain\Repository\UserRepositoryInterface;
use Troupe\TestlabApi\Core\Domain\Service\CreateUser;
use Troupe\TestlabApi\Core\Infrastructure\Persistence\UserRepositoryDoctrineOrm;

// Services
$container[CreateUser::class] = static fn (ContainerInterface $container) =>
    new CreateUser(
        $container->get(UserRepositoryInterface::class)
    );

// Repositories
$container[UserRepositoryInterface::class] = static fn (ContainerInterface $container) =>
    new UserRepositoryDoctrineOrm(
        $container->get('doctrine-testlab')
    );