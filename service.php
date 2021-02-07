<?php
declare(strict_types=1);

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Tools\Console\Command\DumpSchemaCommand;
use Doctrine\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\Migrations\Tools\Console\Command\LatestCommand;
use Doctrine\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\Migrations\Tools\Console\Command\RollupCommand;
use Doctrine\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\Migrations\Tools\Console\Command\VersionCommand;
use Doctrine\Migrations\Tools\Console\Helper\ConfigurationHelper;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\DebugFormatterHelper;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\ProcessHelper;
use Symfony\Component\Console\Helper\QuestionHelper;

return [
    ContainerInterface::class => function (ContainerInterface $c) {
        return $c;
    },
    Application::class => function (ContainerInterface $container) {
        $app = new Application('Custom Applicaiton');
        $app->setHelperSet($container->get(HelperSet::class));
        $app->addCommands(array(
            new DumpSchemaCommand(),
            new ExecuteCommand(),
            new GenerateCommand(),
            new LatestCommand(),
            new MigrateCommand(),
            new RollupCommand(),
            new StatusCommand(),
            new VersionCommand()
        ));
        return $app;
    },
    Connection::class => function (ContainerInterface $container) {
        return DriverManager::getConnection([
            'dbname' => $container->get('DB_NAME'),
            'user' => $container->get('DB_USER'),
            'password' => $container->get('DB_PASSWORD'),
            'host' => $container->get('DB_HOST'),
            'driver' => 'pdo_' . $container->get('DB_TYPE'),
        ]);
    },
    Configuration::class => function (ContainerInterface $container) {
        $configuration = new Configuration($container->get(Connection::class));
        $configuration->setName('My Project Migrations');
        $configuration->setMigrationsNamespace('App\Migration');
        $configuration->setMigrationsTableName('migrations');
        $configuration->setMigrationsColumnName('version');
        $configuration->setMigrationsColumnLength(255);
        $configuration->setMigrationsExecutedAtColumnName('executed_at');
        $configuration->setMigrationsDirectory(__DIR__ . '/src/Migration');
        $configuration->setAllOrNothing(true);
        $configuration->setCheckDatabasePlatform(false);
        return $configuration;
    },
    HelperSet::class => function (ContainerInterface $container) {
        return new HelperSet([
            new FormatterHelper(),
            new DebugFormatterHelper(),
            new ProcessHelper(),
            'question' => new QuestionHelper(),
            'db' => new ConnectionHelper($container->get(Connection::class)),
            new ConfigurationHelper(
                $container->get(Connection::class),
                $container->get(Configuration::class)
            ),
        ]);
    }
];
