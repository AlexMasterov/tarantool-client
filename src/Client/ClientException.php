<?php
declare(strict_types=1);

namespace Tarantool\Client;

use RuntimeException;
use Tarantool\TarantoolException;

final class ClientException extends RuntimeException implements TarantoolException
{
    public const INVALID_GREETING = 1;
    public const UNABLE_PARSE_GREETING = 2;
    public const SESSION_NOT_FOUND = 3;

    public static function invalidGreeting(): ClientException
    {
        return new static(
            'Invalid Greeting: Unable to recognize Tarantool server',
            self::INVALID_GREETING
        );
    }

    public static function unableParseGreeting(): ClientException
    {
        return new static(
            'Unable to parse Greeting',
            self::UNABLE_PARSE_GREETING
        );
    }

    public static function sessionNotFound(): ClientException
    {
        return new static(
            'No Session found for current connection',
            self::SESSION_NOT_FOUND
        );
    }
}
