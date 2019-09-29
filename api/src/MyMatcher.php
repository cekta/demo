<?php
declare(strict_types=1);

namespace App;

use Cekta\Routing\Nikic\DispatcherBuilder;
use Cekta\Routing\Nikic\Handler;
use Cekta\Routing\Nikic\Matcher;
use Cekta\Routing\Nikic\ProviderHandler;
use Cekta\Routing\Nikic\ProviderMiddleware;

class MyMatcher extends Matcher
{
    public function __construct(
        ProviderHandler $providerHandler,
        ProviderMiddleware $providerMiddleware
    ) {
        /** @var DispatcherBuilder $builder */
        $builder = require __DIR__ . '/../app/route.php';
        $notFound = new Handler(DemoNotFoundHandler::class);
        parent::__construct(
            $notFound,
            $builder->build(),
            $providerHandler,
            $providerMiddleware
        );
    }

}
