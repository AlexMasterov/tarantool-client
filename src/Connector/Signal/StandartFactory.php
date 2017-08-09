<?php
declare(strict_types=1);

namespace Tarantool\Connector\Signal;

use Tarantool\Connector\{
    Signal,
    Signal\Standart
};

final class StandartFactory
{
    public function create(iterable $listeners = []): Signal
    {
        return new Standart($listeners);
    }
}
