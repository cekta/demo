#!/usr/bin/env php
<?php

declare(strict_types=1);

use App\ContainerBuilder;
use Cekta\Migrator\Command\MakeMigration;
use Cekta\Migrator\Command\Migrate;
use Cekta\Migrator\Command\Rollback;
use Symfony\Component\Console\Application;

require __DIR__ . '/vendor/autoload.php';

$builder = new ContainerBuilder();
$container = $builder->build();
$application = $container->get(Application::class);
$application->run();