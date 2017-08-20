<?php
declare(strict_types=1);

namespace Tarantool;

use Tarantool\Connector\{
    Request,
    Sensor
};

interface Connector extends Sensor
{
    public function disconnect(): void;

    public function sendRequest(Request $request): array;
}
