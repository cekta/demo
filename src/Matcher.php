<?php
declare(strict_types=1);

namespace App;

use App\HTTP\Hello;
use App\HTTP\NotFound;
use Cekta\Routing\Nikic\DispatcherBuilder;
use Cekta\Routing\Nikic\Handler;
use Cekta\Routing\Nikic\ProviderHandler;
use Cekta\Routing\Nikic\ProviderMiddleware;

class Matcher extends \Cekta\Routing\Nikic\Matcher
{
    public function __construct(
        ProviderHandler $providerHandler,
        ProviderMiddleware $providerMiddleware
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
