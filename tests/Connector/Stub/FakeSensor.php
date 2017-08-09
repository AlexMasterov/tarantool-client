<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Stub;

use Closure;
use Tarantool\Connector\{
    Sensor,
    Sensor\CanListen,
    Signal\CanBeep
};

final class FakeSensor implements Sensor
{
    use CanBeep;
    use CanListen;

    public function addlistener(string $name, Closure $callback): void
    {
        $this->listeners[$name][] = $callback;
    }
}
