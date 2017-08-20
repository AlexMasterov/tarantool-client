<?php
declare(strict_types=1);

namespace Tarantool\Connector;

use Closure;

interface Sensor
{
    public function on(string $event, Closure $listener): void;

    public function off(string $event, Closure $listener): void;
}
