#!/usr/bin/env php
<?php
declare(strict_types=1);

use App\Container;
use Symfony\Component\Console\Application;

require __DIR__ . '/vendor/autoload.php';

$container = new Container();
$app = $container->get(Application::class);
try {
    $app->run();
} catch (Throwable $e) {
    echo $e;
}
