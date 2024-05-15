<?php

use Psr\Container\ContainerInterface;
use Troupe\TestlabApi\Core\Domain\Repository\UserRepositoryInterface;
use Troupe\TestlabApi\TestCases\Domain\Repository\FolderRepositoryInterface;
use Troupe\TestlabApi\TestCases\Domain\Repository\ProjectRepositoryInterface;
use Troupe\TestlabApi\TestCases\Domain\Service\CreateFolder;
use Troupe\TestlabApi\TestCases\Domain\Service\CreateProject;
use Troupe\TestlabApi\TestCases\Domain\Service\DeleteProject;
use Troupe\TestlabApi\TestCases\Domain\Service\UpdateProject;
use Troupe\TestlabApi\TestCases\Infrastructure\Persistence\FolderRepositoryDoctrineOrm;
use Troupe\TestlabApi\TestCases\Infrastructure\Persistence\ProjectRepositoryDoctrineOrm;

// Services
$container[CreateProject::class] = static fn (ContainerInterface $container) =>
    new CreateProject(
        $container->get(ProjectRepositoryInterface::class),
        $container->get(UserRepositoryInterface::class)
    );

$container[UpdateProject::class] = static fn (ContainerInterface $container) =>
    new UpdateProject(
        $container->get(ProjectRepositoryInterface::class)
    );

$container[DeleteProject::class] = static fn (ContainerInterface $container) =>
    new DeleteProject(
        $container->get(ProjectRepositoryInterface::class)
    );

$container[CreateFolder::class] = static fn (ContainerInterface $container) =>
    new CreateFolder(
        $container->get(FolderRepositoryInterface::class),
        $container->get(ProjectRepositoryInterface::class)
    );

// Repositories
$container[ProjectRepositoryInterface::class] = static fn (ContainerInterface $container) =>
    new ProjectRepositoryDoctrineOrm(
        $container->get('doctrine-testlab')
    );

$container[FolderRepositoryInterface::class] = static fn (ContainerInterface $container) =>
    new FolderRepositoryDoctrineOrm(
        $container->get('doctrine-testlab')
    );