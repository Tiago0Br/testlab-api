<?php

use Psr\Container\ContainerInterface;
use Troupe\TestlabApi\Core\Domain\Repository\UserRepositoryInterface;
use Troupe\TestlabApi\TestCases\Domain\Repository\ProjectRepositoryInterface;
use Troupe\TestlabApi\TestCases\Domain\Service\CreateProject;
use Troupe\TestlabApi\TestCases\Infrastructure\Persistence\ProjectRepositoryDoctrineOrm;

// Services
$container[CreateProject::class] = static fn (ContainerInterface $container) =>
    new CreateProject(
        $container->get(ProjectRepositoryInterface::class),
        $container->get(UserRepositoryInterface::class)
    );

// Repositories
$container[ProjectRepositoryInterface::class] = static fn (ContainerInterface $container) =>
    new ProjectRepositoryDoctrineOrm(
        $container->get('doctrine-testlab')
    );