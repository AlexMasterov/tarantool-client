<?php
declare(strict_types=1);

namespace Tarantool\Connector\Tests\Stub;

interface State
{
    public const NONE = 0;
    public const CONNECTED = 1;
    public const DATA_RECEIVED = 2;
}
