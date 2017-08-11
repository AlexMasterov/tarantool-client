<?php
declare(strict_types=1);

namespace Tarantool\Connector\Signal;

trait CanBeep
{
    /** @var iterable */
    private $listeners = [];

    public function beep(string $name, $result = null): void
    {
        if (!isset($this->listeners[$name])) {
            return;
        }

        foreach ($this->listeners[$name] as $listener) {
            $listener($result);
        }
    }
}
