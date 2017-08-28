<?php
declare(strict_types=1);

namespace Tarantool\Client;

use RuntimeException;
use Tarantool\TarantoolException;

final class ClientException extends RuntimeException implements TarantoolException
{
    public const SESSION_NOT_FOUND = 1;

    public static function sessionNotFound(): ClientException
    {
        return new static(
            'No session found for current connection',
            self::SESSION_NOT_FOUND
        );
    }
}
