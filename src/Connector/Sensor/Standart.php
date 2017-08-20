<?php
declare(strict_types=1);

namespace Tarantool\Connector\Sensor;

use Closure;
use Tarantool\Connector\Sensor;

class Standart implements Sensor
{
    /** @var iterable */
    private $listeners = [];

    public function __construct(iterable $listeners = [])
    {
        $this->listeners = $listeners;
    }

    public function on(string $event, Closure $listener): void
    {
        $this->listeners[$event][] = $listener;
    }

    public function off(string $event, Closure $listener): void
    {
        if (!isset($this->listeners[$event])) {
            return;
        }

        $key = \array_search($listener, $this->listeners[$event], true);

        if (false !== $key) {
            unset($this->listeners[$event][$key]);
        }
    }

    public function emit(string $event, ...$arguments): void
    {
        if (!isset($this->listeners[$event])) {
            return;
        }

        foreach ($this->listeners[$event] as $listener) {
            $listener(...$arguments);
        }
    }
}
