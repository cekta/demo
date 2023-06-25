<?php

declare(strict_types=1);

namespace App;

use Dotenv\Dotenv;

class ContainerBuilder extends \Cekta\DI\ContainerBuilder
{
    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
        $this->params(
            array_map(function ($value) {
                if (is_string($value)) {
                    switch (strtolower($value)) {
                        case 'true':
                        case '(true)':
                            return true;
                        case 'false':
                        case '(false)':
                            return false;
                        case 'empty':
                        case '(empty)':
                            return '';
                        case 'null':
                        case '(null)':
                            return null;
                    }
                    if (preg_match('/\A([\'"])(.*)\1\z/', $value, $matches)) {
                        return $matches[2];
                    }
                }
                return $value;
            }, $_SERVER + $_ENV + getenv())
        );
        $this->definitions(require __DIR__ . '/../service.php');
        $this->alias(require __DIR__ . '/../implementation.php');
    }
}
