<?php
declare(strict_types=1);

use App\Container;
use Cekta\HTTP\Server\SapiEmitter;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\ServerRequestFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();
$response = $container->get(RequestHandlerInterface::class)->handle(ServerRequestFactory::fromGlobals());
$container->get(SapiEmitter::class)->emit($response);
