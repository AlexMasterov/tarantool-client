<?php
declare(strict_types=1);

namespace Tarantool\Connector\Signal;

use Closure;
use Tarantool\Connector\{
    Signal,
    Signal\CanAddListener,
    Signal\CanBeep
};

final class Standart implements Signal
{
    use CanAddListener;
    use CanBeep;

    /** @var iterable */
    private $listeners = [];

    public function __construct(iterable $listeners = [])
    {
        $this->listeners = $listeners;
    }
}
