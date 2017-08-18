<?php
declare(strict_types=1);

namespace Tarantool\Connector\Connection;

use RuntimeException;
use Tarantool\TarantoolException;

final class ConnectionException extends RuntimeException implements TarantoolException
{
    public const CANNOT_WRITE = 1;
    public const UNABLE_READ_BYTES = 2;
    public const TIMEOUT = 3;
    public const CANNOT_COMMUNICATE = 4;

    public static function cannotWrite(): ConnectionException
    {
        return new static(
            'Cannot write to stream',
            self::CANNOT_WRITE
        );
    }

    public static function unableReadBytes(int $bytes): ConnectionException
    {
        return new static(
            "Unable to read data bytes ({$bytes}) from stream",
            self::UNABLE_READ_BYTES
        );
    }

    public static function timeout(): ConnectionException
    {
        return new static(
            'Connection has timed out',
            self::TIMEOUT
        );
    }

    public static function cannotCommunicate(): ConnectionException
    {
        return new static(
            'Cannot communicate when there is no connection',
            self::CANNOT_COMMUNICATE
        );
    }
}
