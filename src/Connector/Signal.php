<?php
declare(strict_types=1);

namespace Tarantool\Connector;

use Closure;

interface Signal
{
    public function addlistener(string $name, Closure $callback): void;

    public function beep(string $name, $result = null): void;
}
