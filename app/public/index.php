<?php
declare(strict_types=1);

use App\ExampleContainer;
use App\MyMatcher;
use Cekta\HTTP\Server\Application;
use Cekta\HTTP\Server\SapiEmitter;
use Cekta\Routing\Nikic\ProviderHandler;
use Cekta\Routing\Nikic\ProviderMiddleware;
use Zend\Diactoros\ServerRequestFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = new ExampleContainer();
$providerHandler = new ProviderHandler($container);
$providerMiddleware = new ProviderMiddleware($container);
$matcher = new MyMatcher($providerHandler, $providerMiddleware);
$request = ServerRequestFactory::fromGlobals();
$application = new Application($matcher);
$response = $application->handle($request);

$emiter = new SapiEmitter();
$emiter->emit($response);
