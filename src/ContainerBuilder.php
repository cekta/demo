<?php

declare(strict_types=1);

namespace App;

use Cekta\HTTP\Server\Application;
use Cekta\Migrator\Command\MakeMigration;
use Cekta\Migrator\Command\Migrate;
use Cekta\Migrator\Command\Rollback;
use Cekta\Migrator\MigrationLocator;
use Cekta\Migrator\Storage;
use Cekta\Routing\MatcherInterface;
use PDO;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ContainerBuilder extends \Cekta\DI\ContainerBuilder
{
    public function __construct()
    {
        $params = [
            'DB_OPTIONS' => [],
            'DB_MIGRATOR_TABLE_NAME' => 'migrations',
            'DB_MIGRATOR_COLUMN_ID' => 'id',
            'DB_MIGRATOR_COLUMN_CLASS' => 'class',
            '...migrations' => [],
        ];
        $this->params(
            array_map(function ($value) {
                if (is_string($value)) {
                    switch (strtolower($value)) {
                        case 'true':
                        case '(true)':
                            return true;
                        case 'false':
                        case '(false)':
                            return false;
                        case 'empty':
                        case '(empty)':
                            return '';
                        case 'null':
                        case '(null)':
                            return null;
                    }
                    if (preg_match('/\A([\'"])(.*)\1\z/', $value, $matches)) {
                        return $matches[2];
                    }
                }
                return $value;
            }, $_SERVER + $_ENV + getenv() + $params)
        );
        $this->definitions([
            ContainerInterface::class => function (ContainerInterface $c) {
                return $c;
            },
            'dsn' => function(ContainerInterface $c) {
                return "{$c->get('DB_TYPE')}:host={$c->get('DB_HOST')};dbname={$c->get('DB_NAME')}";
            },
            Migrate::class => function (ContainerInterface $c) {
                return new Migrate($c->get(Storage::class), $c->get(MigrationLocator::class));
            },
            Rollback::class => function (ContainerInterface $c) {
                return new Rollback($c->get(Storage::class), $c->get(MigrationLocator::class));
            },
            MakeMigration::class => function () {
                return new MakeMigration();
            },
            \Symfony\Component\Console\Application::class => function (ContainerInterface $c) {
                $application = new \Symfony\Component\Console\Application();
                $application->addCommands([
                    $c->get(Migrate::class),
                    $c->get(Rollback::class),
                    $c->get(MakeMigration::class),
                ]);
                return $application;
            }
        ]);
        $this->alias([
            MatcherInterface::class => Matcher::class,
            RequestHandlerInterface::class => Application::class,
            Storage::class => Storage\DB::class,
            Storage\DB::class . '$table_name' => 'DB_MIGRATOR_TABLE_NAME',
            Storage\DB::class . '$column_id' => 'DB_MIGRATOR_COLUMN_ID',
            Storage\DB::class . '$column_class' => 'DB_MIGRATOR_COLUMN_CLASS',
            PDO::class . '$username' => 'DB_USER',
            PDO::class . '$password' => 'DB_PASSWORD',
            PDO::class . '$options' => 'DB_OPTIONS',
        ]);
    }
}
