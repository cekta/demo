<?php
declare(strict_types=1);

use App\DemoHandler;
use App\DemoMiddleware;
use App\DemoUserHandler;
use Cekta\Routing\Nikic\DispatcherBuilder;

$builder = new DispatcherBuilder();

$builder->get('/', DemoHandler::class, DemoMiddleware::class);
$builder->get('/user/{id:\d+}', DemoUserHandler::class);

return $builder;
