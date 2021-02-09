<?php
declare(strict_types=1);

use App\Matcher;
use Cekta\HTTP\Server\Application;
use Cekta\Routing\MatcherInterface;
use Psr\Http\Server\RequestHandlerInterface;

return [
    MatcherInterface::class => Matcher::class,
    RequestHandlerInterface::class => Application::class,
];
