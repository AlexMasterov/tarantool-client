<?php
declare(strict_types=1);

namespace Tarantool\Connector\Connection;

use RuntimeException;
use Tarantool\TarantoolException;

final class ConnectionException extends RuntimeException implements TarantoolException
{
    public static function unableConnect(string $host, string $message, int $code): ConnectionException
    {
        return new static("Unable to connect to {$host}: {$message}", $code);
    }

    public static function cannotWrite(): ConnectionException
    {
        return new static('Cannot write to stream');
    }

    public static function unableReadBytes(int $bytes): ConnectionException
    {
        return new static("Unable to read data bytes ({$bytes}) from stream");
    }

    public static function timeout(): ConnectionException
    {
        return new static('Connection has timed out');
    }

    public static function cannotCommunicate(): ConnectionException
    {
        return new static('Cannot communicate when there is no connection');
    }
}
