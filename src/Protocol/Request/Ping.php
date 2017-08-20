<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Request;

use Tarantool\Protocol\Request;

final class Ping implements Request
{
    public function header(): array
    {
        return [
            self::CODE => self::PING,
        ];
    }

    public function body(): array
    {
        return [];
    }
}
