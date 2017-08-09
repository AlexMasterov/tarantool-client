<?php
declare(strict_types=1);

namespace Tarantool\Client\Command;

use Tarantool\Client\Command;

final class Ping implements Command
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
