<?php
declare(strict_types=1);

namespace Tarantool\Connector\Sensor;

use Closure;

trait CanDecoratedListen
{
    public function listen(string $name, Closure $callback): void
    {
        $this->decoratedConnector->listen($name, $callback);
    }
}
