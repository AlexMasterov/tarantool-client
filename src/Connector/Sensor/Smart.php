<?php
declare(strict_types=1);

namespace Tarantool\Connector\Sensor;

use Closure;
use Tarantool\Connector\{
    Sensor,
    Sensor\StandartFactory
};

final class Smart implements Sensor
{
    /** @var StandartFactory */
    private $factory;

    /** @var iterable */
    private $listeners = [];

    public function __construct(
        StandartFactory $factory,
        iterable $listeners = []
    ) {
        $this->factory = $factory;
        $this->listeners = $listeners;
    }

    public function on(string $event, Closure $listener): void
    {
        $this->factory->create($this->listeners)
            ->on($event, $listener);
    }

    public function off(string $event, Closure $listener): void
    {
        $this->factory->create($this->listeners)
            ->off($event, $listener);
    }

    public function emit(string $event, ...$arguments): void
    {
        $this->factory->create($this->listeners)
            ->emit($event, ...$arguments);
    }
}
