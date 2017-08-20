<?php
declare(strict_types=1);

namespace Tarantool\Connector\Sensor;

use Closure;
use Tarantool\Connector\Sensor;

final class Proxy extends Standart implements Sensor
{
    /** @var Sensor */
    private $proxiedSensor;

    public function __construct(
        Sensor $sensor,
        iterable $listeners = []
    ) {
        $this->proxiedSensor = $sensor;
        $this->listeners = $listeners;
    }

    public function on(string $event, Closure $listener): void
    {
        if (isset($this->listeners[$event])) {
            parent::on($event, $listener);
        }

        $this->proxiedSensor->on($event, $listener);
    }
}
