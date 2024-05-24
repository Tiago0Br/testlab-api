<?php

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Psr\Container\ContainerInterface;
use Troupe\TestlabApi\Core\Application\Auth\Authentication;
use Troupe\TestlabApi\Core\Domain\Repository\UserRepositoryInterface;
use Troupe\TestlabApi\Core\Domain\Service\CreateUser;
use Troupe\TestlabApi\Core\Domain\Service\LoginService;
use Troupe\TestlabApi\Core\Infrastructure\Persistence\UserRepositoryDoctrineOrm;

// Auth
$container[Authentication::class] = static fn (ContainerInterface $container) =>
    new Authentication(
        Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText(getenv('AUTH_TOKEN_SIGNER_KEY'))
        )
    );

// Services
$container[CreateUser::class] = static fn (ContainerInterface $container) =>
    new CreateUser(
        $container->get(UserRepositoryInterface::class)
    );

$container[LoginService::class] = static fn (ContainerInterface $container) =>
    new LoginService(
        $container->get(UserRepositoryInterface::class)
    );

// Repositories
$container[UserRepositoryInterface::class] = static fn (ContainerInterface $container) =>
    new UserRepositoryDoctrineOrm(
        $container->get('doctrine-testlab')
    );