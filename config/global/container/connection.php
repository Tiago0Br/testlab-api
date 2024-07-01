<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;

/**
 * @var ContainerInterface $container
 * @return EntityManager
 */
$container['doctrine-testlab'] = static function () {
    $connectionParams = [
        'dbname'   => getenv('DB_NAME'),
        'user'     => getenv('DB_USER'),
        'password' => getenv('DB_PASS'),
        'host'     => getenv('DB_HOST'),
        'port'     => getenv('DB_PORT'),
        'driver'   => 'pdo_mysql',
        'charset'  => 'utf8',
    ];

    $paths = [__DIR__ . '/../../../src'];
    $isDevMode = getenv('APP_ENV') != 'production';

    $config = ORMSetup::createAttributeMetadataConfiguration(
        paths: array(__DIR__."/src"),
        isDevMode: $isDevMode,
    );

    $config->setMetadataDriverImpl(new AttributeDriver($paths, $isDevMode));
    $config->setProxyDir(__DIR__ . '/../../../data/cache/Proxies');
    $config->setProxyNamespace('cache\Proxies');

    $connection = DriverManager::getConnection($connectionParams, $config);

    return new EntityManager($connection, $config);
};