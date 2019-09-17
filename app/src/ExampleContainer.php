<?php
declare(strict_types=1);

namespace App;

use Psr\Container\ContainerInterface;

/**
 * Это лишь пример, позже он будет заменен
 */
class ExampleContainer implements ContainerInterface
{
    private $values;

    public function __construct()
    {
        $this->values[DemoNotFoundHandler::class] = new DemoNotFoundHandler();
        $this->values[DemoHandler::class] = new DemoHandler();
        $this->values[DemoUserHandler::class] = new DemoUserHandler();
        $this->values[DemoMiddleware::class] = new DemoMiddleware();
    }

    public function get($id)
    {
        return $this->values[$id];
    }

    public function has($id)
    {
        return array_key_exists($id, $this->values);
    }
}
