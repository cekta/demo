<?php
declare(strict_types=1);

namespace App;

use Cekta\DI\Container;
use Cekta\DI\Provider\Autowiring;
use Cekta\DI\Provider\KeyValue;

class MyContainer extends Container
{
    public function __construct()
    {
        $providers[] = KeyValue::stringToAlias(require __DIR__ . '/../implementation.php');
        $providers[] = new Autowiring();
        parent::__construct(...$providers);
    }
}
