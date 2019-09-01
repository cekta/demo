<?php
declare(strict_types=1);

use App\DemoMatcher;
use Cekta\HTTP\Server\Application;
use Cekta\HTTP\Server\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

require __DIR__ . '/../vendor/autoload.php';

$request = ServerRequestFactory::fromGlobals();
$application = new Application(new DemoMatcher());
$response = $application->handle($request);

$emiter = new SapiEmitter();
$emiter->emit($response);
