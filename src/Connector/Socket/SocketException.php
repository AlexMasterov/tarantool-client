<?php
declare(strict_types=1);

namespace Tarantool\Connector\Socket;

use RuntimeException;
use Tarantool\TarantoolException;

final class SocketException extends RuntimeException implements TarantoolException
{
    public static function unableConnect(string $target, string $message, int $code): SocketException
    {
        return new static(
            "Unable to connect to {$target} socket: {$message}",
            $code
        );
    }
}
