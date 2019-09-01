<?php
declare(strict_types=1);

namespace App;

use Cekta\Routing\RouteInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DemoRoute implements RouteInterface
{
    /**
     * @var ServerRequestInterface
     */
    private $request;

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function getHandler(): RequestHandlerInterface
    {
        return new DemoHandler();
    }

    /**
     * @return MiddlewareInterface[]
     */
    public function getMiddlewares(): array
    {
        return [];
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }
}
