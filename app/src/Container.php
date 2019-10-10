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
        $dotenv = Dotenv::create(__DIR__ . '/../');
        $dotenv->load();
        $providers[] = new KeyValue(getenv());
        $providers[] = KeyValue::stringToAlias(require __DIR__ . '/../implementation.php');
        $providers[] = KeyValue::closureToService(require __DIR__ . '/../service.php');
        $providers[] = new Autowiring();
        parent::__construct(...$providers);
    }
}
