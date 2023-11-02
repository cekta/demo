<?php

declare(strict_types=1);

namespace App;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HandlerLocator implements \Cekta\Routing\Nikic\HandlerLocator
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function get(string $handleName): RequestHandlerInterface
    {
        return $this->container->get($handleName);
    }
}
