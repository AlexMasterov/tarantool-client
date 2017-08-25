<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Request;

use Tarantool\Protocol\Request;
use const Tarantool\Protocol\{
    CODE,
    PING
};

final class Ping implements Request
{
    public function header(): array
    {
        return [
            CODE => PING,
        ];
    }

    public function body(): array
    {
        return [];
    }
}
