<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Request;

use Tarantool\Protocol\Request;

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
            self::CODE => self::JOIN,
        ];
    }

    public function body(): array
    {
        return [
            self::SERVER_UUID => $this->serverUuid,
        ];
    }
}
