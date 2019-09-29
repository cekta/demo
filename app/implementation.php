<?php
declare(strict_types=1);

use App\MyMatcher;
use Cekta\DI\Loader\Service;
use Cekta\Routing\MatcherInterface;
use Psr\Container\ContainerInterface;

return [
    MatcherInterface::class => MyMatcher::class,
    ContainerInterface::class => new Service(function (ContainerInterface $c) {
        return $c;
    })
];
