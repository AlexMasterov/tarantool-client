<?php
declare(strict_types=1);

namespace Tarantool\Connector;

use Tarantool\Connector\Sensor;

interface Connection
{
    public function open(): void;

    public function close(): void;

    public function send(string $data): int;

    public function receive(int $bytes): string;
}
