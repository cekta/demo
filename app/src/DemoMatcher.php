<?php
declare(strict_types=1);

namespace App;

use Cekta\Routing\MatcherInterface;
use Cekta\Routing\RouteInterface;
use Psr\Http\Message\ServerRequestInterface;

class DemoMatcher implements MatcherInterface
{
    public function match(ServerRequestInterface $request): RouteInterface
    {
        return new DemoRoute($request);
    }
}
