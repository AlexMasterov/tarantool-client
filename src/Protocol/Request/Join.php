<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Request;

use Tarantool\Protocol\Request;
use const Tarantool\Protocol\{
    CODE,
    JOIN,
    SERVER_UUID
};

final class Join implements Request
{
    /** @var string */
    private $serverUuid;

    public function __construct(string $serverUuid)
    {
        $this->serverUuid = $serverUuid;
    }

    public function header(): array
    {
        return [
            CODE => JOIN,
        ];
    }

    public function body(): array
    {
        return [
            SERVER_UUID => $this->serverUuid,
        ];
    }
}
