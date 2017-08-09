<?php
declare(strict_types=1);

namespace Tarantool\Connector;

use Closure;

interface Sensor
{
    public function listen(string $name, Closure $callback): void;
}
