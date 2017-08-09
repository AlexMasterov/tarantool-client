<?php
declare(strict_types=1);

namespace Tarantool\Connector\Signal;

use Closure;
use Tarantool\Connector\{
    Signal,
    Signal\CanAddListener,
    Signal\StandartFactory
};

final class Smart implements Signal
{
    use CanAddListener;

    /** @var StandartFactory */
    private $factory;

    public function __construct(
        StandartFactory $factory,
        iterable $listeners = []
    ) {
        $this->factory = $factory;
        $this->listeners = $listeners;
    }

    public function beep(string $name, $result = null): void
    {
        $this->factory->create($this->listeners)
            ->beep($name, $result);
    }
}
