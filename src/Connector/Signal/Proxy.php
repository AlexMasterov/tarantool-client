<?php
declare(strict_types=1);

namespace Tarantool\Connector\Signal;

use Closure;
use Tarantool\Connector\{
    Sensor,
    Signal,
    Signal\CanBeep
};

final class Proxy implements Signal
{
    use CanBeep;

    /** @var Sensor */
    private $proxiedSensor;

    public function __construct(
        Sensor $proxiedSensor,
        iterable $listeners = []
    ) {
        $this->proxiedSensor = $proxiedSensor;
        $this->listeners = $listeners;
    }

    public function addlistener(string $name, Closure $callback): void
    {
        if (isset($this->listeners[$name])) {
            $this->listeners[$name][] = $callback;
        }

        $this->proxiedSensor->listen($name, $callback);
    }
}
