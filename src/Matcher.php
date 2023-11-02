<?php
declare(strict_types=1);

namespace App;

use App\HTTP\Hello;
use App\HTTP\NotFound;
use Cekta\Routing\Nikic\DispatcherBuilder;
use Cekta\Routing\Nikic\Handler;

class Matcher extends \Cekta\Routing\Nikic\Matcher
{
    public function __construct(
        HandlerLocator $providerHandler,
        MiddlewareLocator $providerMiddleware
    ) {
        $builder = new DispatcherBuilder();
        $builder->get('/', Hello::class);
        parent::__construct(
            new Handler(NotFound::class),
            $builder->build(),
            $providerHandler,
            $providerMiddleware
        );
    }

}
