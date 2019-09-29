<?php
declare(strict_types=1);

use App\MyContainer;
use Cekta\HTTP\Server\Application;
use Cekta\HTTP\Server\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = new MyContainer();
$container->get(SapiEmitter::class)->emit(
    $container->get(Application::class)->handle(ServerRequestFactory::fromGlobals())
);
