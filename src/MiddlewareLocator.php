<?php

declare(strict_types=1);

namespace App;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;

class MiddlewareLocator implements \Cekta\Routing\Nikic\MiddlewareLocator
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function get(string $middlewareName): MiddlewareInterface
    {
        return $this->container->get($middlewareName);
    }
}
