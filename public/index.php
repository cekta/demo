<?php
declare(strict_types=1);

use App\ContainerBuilder;
use Cekta\HTTP\Server\SapiEmitter;
use Laminas\Diactoros\ServerRequestFactory;
use Psr\Http\Server\RequestHandlerInterface;

require __DIR__ . '/../vendor/autoload.php';

$builder = new ContainerBuilder();
$container = $builder->build();
$response = $container->get(RequestHandlerInterface::class)->handle(ServerRequestFactory::fromGlobals());
$container->get(SapiEmitter::class)->emit($response);
