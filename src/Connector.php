<?php
declare(strict_types=1);

namespace Tarantool;

use Closure;
use Tarantool\Protocol\Request;

interface Connector
{
    public function on(string $event, Closure $listener): void;

    public function off(string $event, Closure $listener): void;

    public function disconnect(): void;

    public function sendRequest(Request $request): array;
}
