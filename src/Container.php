<?php
declare(strict_types=1);

namespace App;

use Cekta\DI\Provider\Autowiring;
use Cekta\DI\Provider\KeyValue;
use Dotenv\Dotenv;

class Container extends \Cekta\DI\Container
{
    public function __construct()
    {
        $dotenv = Dotenv::create(__DIR__ . "/../");
        $dotenv->load();
        $providers[] = new KeyValue(array_map(function ($value) {
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
        },$_SERVER + $_ENV + getenv()));
        $providers[] = KeyValue::stringToAlias(require __DIR__ . '/../implementation.php');
        $providers[] = new KeyValue(require __DIR__ . '/../service.php');
        $providers[] = new Autowiring();
        parent::__construct(...$providers);
    }
}
