<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;

return [
    ContainerInterface::class => function (ContainerInterface $c) {
        return $c;
    },
];
