<?php
declare(strict_types=1);

namespace Tarantool\Protocol\Greeting;

use RuntimeException;
use Tarantool\TarantoolException;

final class GreetingException extends RuntimeException implements TarantoolException
{
    public const INVALID_LENGTH = 1;
    public const UNABLE_RECOGNIZE_SERVER = 2;
    public const UNABLE_DECODE_SALT = 3;

    public static function invalidLength(): GreetingException
    {
        return new static(
            'Invalid length of a text greeting message',
            self::INVALID_LENGTH
        );
    }

    public static function unableRecognizeServer(string $greeting): GreetingException
    {
        return new static(
            "Unable to recognize server in the string: {$greeting}",
            self::UNABLE_RECOGNIZE_SERVER
        );
    }

    public static function unableDecodeSalt(string $encodedSalt): GreetingException
    {
        return new static(
            "Unable to decode salt: {$encodedSalt}",
            self::UNABLE_DECODE_SALT
        );
    }
}
