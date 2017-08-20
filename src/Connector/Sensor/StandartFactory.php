<?php
declare(strict_types=1);

namespace Tarantool\Connector\Sensor;

use Tarantool\Connector\{
    Sensor,
    Sensor\Standart
};

final class StandartFactory
{
    /** @var iterable */
    private $listeners = [];

    public function __construct(iterable $listeners = [])
    {
        $this->listeners = $listeners;
    }

    public function create(iterable $listeners = []): Sensor
    {
        return new Standart($listeners);
    }
}
